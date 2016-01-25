
//Initialisation des librairies systèmes

#include "SPI.h"
#include "Arduino.h"
#include "Wire.h"

//Initialisation des librairies pour le bon fonctionnement des capteurs

#include "Adafruit_HDC1000.h"
#include "Adafruit_MPL115A2.h"
#include "AS3935.h"

//Variables contenant la latitude et la longitude précise de la station météo

byte SPItransfer(byte sendByte);

void AS3935Irq();
volatile int AS3935IrqTriggered;

#define LATITUDE_STATION ***
#define LONGITUDE_STATION ***

//Mise en place des variables contenant les différents pin dans lesquels les capteurs sonts connectés

#define PIN_VANE        A0
#define PIN_UV  A1  
#define PIN_ANEMOMETER  2
#define PIN_RAINGAUGE   3 

//Initialisation des variables utiles au module de détection d'orage (distance / intérieur / exterieur)

#define AS3935_CAPACITANCE 5

//Initialisation du temps de calcul entre chaque mesure 

#define MSECS_CALC_WIND_SPEED 60000
#define MSECS_CALC_RAIN_FALL  60000
#define MSECS_CALC_WIND_DIR  60000
#define MSECS_CALC_TEMP  180000
#define MSECS_CALC_UV 72000000
#define MSECS_CALC_PRESSURE  180000

//Variable contenant le SSID du réseau wifi ainsi que son mot de passe mais aussi le code d'identification lors de la requête POST

String ESP_SSID = "***";
String ESP_WPA = "***";
String ESP_RQST_SECRET_KEY = "***";

//Initialisation des variables contenant le nombre d'interruption de l'anémomètre et du pluviomètre ainsi que la variable détectant une interruption

volatile int irqAnemometer = 0; 
volatile int irqDropsRainGauge = 0;
volatile int8_t irqLightning = 0;

unsigned long nextCalcSpeed;    
unsigned long nextCalcDir;        
unsigned long nextCalcRain;     
unsigned long nextCalcTEMP; 
unsigned long nextCalcUV;   
unsigned long nextCalcPRESSURE;  
unsigned long time;        

//Gestion des directions de la girouette

#define NUMDIRS 8

unsigned long   adc[NUMDIRS] = {26, 45, 77, 118, 161, 196, 220, 256};

char *strVals[NUMDIRS] = {"O","NO","N","SO","NE","S","SE","E"};
byte dirOffset=0;

//Mise en place des librairies incluses précédemment

Adafruit_MPL115A2 MPL;
Adafruit_HDC1000 HDC = Adafruit_HDC1000();
AS3935 LIGHTNING(SPItransfer,10,2);

//Initialisation des différents capteurs, des interruptions, des pins et du module ESP8266

void setup() {

	Serial.begin(9600);
	Serial2.begin(115200);
	Wire.begin();
	HDC.begin();
	MPL.begin();
	SPI.begin();

	SPI.setDataMode(SPI_MODE1);
	SPI.setClockDivider(SPI_CLOCK_DIV16);
	SPI.setBitOrder(MSBFIRST);

	LIGHTNING.reset();
	LIGHTNING.tune(5),
	LIGHTNING.setIndoors();
	LIGHTNING.enableDisturbers();
	AS3935IrqTriggered = 0;

	initESP8266();

	pinMode(PIN_ANEMOMETER, INPUT);

	digitalWrite(PIN_ANEMOMETER, HIGH);
	digitalWrite(PIN_RAINGAUGE, HIGH);

	attachInterrupt(0, countAnemometer, FALLING);
	attachInterrupt(1, countRainGauge, FALLING);
	attachInterrupt(5,AS3935_Interrupt,RISING);

	nextCalcRain = millis() + MSECS_CALC_RAIN_FALL;
    nextCalcSpeed = millis() + MSECS_CALC_WIND_SPEED;
    nextCalcDir   = millis() + MSECS_CALC_WIND_DIR;
 	nextCalcTEMP = millis() + MSECS_CALC_TEMP ;
	nextCalcUV  = millis() + MSECS_CALC_UV;
	nextCalcPRESSURE = millis() + MSECS_CALC_PRESSURE;

	Serial.println("--Programme OK");

}

//Tant qu'aucune interruption du capteur d'orage n'est détecté, on envoie les différentes valeurs de météo toutes les 2 minutes
//Si une interruption est détecté, on stoppe l'envoie des différentes valeurs pour envoyer celles venant du capteur d'orage

void loop() {

	while(AS3935IrqTriggered == 0){

		time = millis();

	   if (time >= nextCalcSpeed) {
	      calcWindSpeed();
	      nextCalcSpeed = time + MSECS_CALC_WIND_SPEED;
	   }
	   if (time >= nextCalcDir) {
	      calcWindDir();
	      nextCalcDir = time + MSECS_CALC_WIND_DIR;
	   }
	   if (time >= nextCalcRain) {
	      calcRainFall();
	      nextCalcRain = time + MSECS_CALC_RAIN_FALL;
	   }
	   if (time >= nextCalcTEMP) {
	      calcTemp();
	      nextCalcTEMP = time + MSECS_CALC_TEMP;
	   }
	   if (time >= nextCalcPRESSURE) {
	      calcPressure();
	      nextCalcPRESSURE = time + MSECS_CALC_PRESSURE;
	   }
	   if (time >= nextCalcUV) {
	      calcUV();
	      nextCalcUV = time + MSECS_CALC_UV;
	   }

	}

	AS3935IrqTriggered = 0;

    int irqSource = LIGHTNING.interruptSource();

    if (irqSource & 0b1000){

		int distance = LIGHTNING.lightningDistanceKm();

		if (distance < 63 && distance > 1){
      		
      		Serial.println("--ORAGE DETECTÉ");
      		sendESP8266("GET ***?type=lightning&value="+ String(distance) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
			receiveESP8266(2000);
		}

    }

}

//Fonctions permettant d'ajouter des interruptions

void countAnemometer() {
	irqAnemometer++;
}

void countRainGauge() {
	irqDropsRainGauge++;
}

void AS3935_Interrupt(){
	AS3935IrqTriggered = 1;
}

//Calcul la direction du vent en fonction de la résistance du capteur

void calcWindDir() {

	int dirVal;
	byte x, reading;

	dirVal = analogRead(PIN_VANE);
	dirVal >>=2;                    
	reading = dirVal;

	for (x=0; x<NUMDIRS; x++) {
		if (adc[x] >= reading)
		break;
	}

	x = x % 8;  

	Serial.println("-Direction du vent : " + String(strVals[x]));

	sendESP8266("GET ***?type=windDir&value="+ String(strVals[x]) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);

}


//Calcul la vitesse du vent (1 tour = 2,4km/h)

void calcWindSpeed() {

	long speed = 24011;
	speed *= irqAnemometer;
	speed /= MSECS_CALC_WIND_SPEED;

	int x1Speed = speed / 10;
	int x2Speed = speed % 10;

	Serial.println("-Vitesse du vent : " + String(x1Speed) + "." + String(x2Speed) + "Km/h");

	sendESP8266("GET ***?type=windSpeed&value="+ String(x1Speed) + "." + String(x2Speed) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);

	irqAnemometer = 0; 

}

//Calcul le volume de pluie (1 interruption = 2,794mm d'eau)

void calcRainFall() {

	long volume = 2794;
	volume *= irqDropsRainGauge;
	volume /= MSECS_CALC_RAIN_FALL;  

	int x1Volume = volume / 10000;
	int x2Volume = volume % 10000;

	Serial.println("-Pluie : " + String(x1Volume) + "." + String(x2Volume) + "mm");

	sendESP8266("GET ***?type=rainFall&value="+ String(x1Volume) + "." + String(x2Volume) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);
	   
	irqDropsRainGauge = 0; 

}

//Fonction permettant le calcul de la température et de l'humidité

void calcTemp() {

	float temperature = HDC.readTemperature();
	float humidity = HDC.readHumidity()*1.330416666666666;
	double dewPoint = calcDewPoint(temperature, humidity);
	Serial.println("-Température : " + String(temperature) + "°C");
	sendESP8266("GET ***?type=temperature&value="+ String(temperature) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);
	Serial.println("-Humidité : " + String(humidity) + "%");
	sendESP8266("GET ***?type=humidity&value="+ String(humidity) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);
	Serial.println("-Point de Rosée : " + String(dewPoint) + "°C");
	sendESP8266("GET ***?type=dewPoint&value="+ String(dewPoint) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);

}

//Fonction permettant le calcul de la pression en Pascal et en HectoPascal

void calcPressure() {

	float pressure = MPL.getPressure();
	Serial.println("-Pression Barométrique : " + String(pressure) + "kPa");
	Serial.println("-Pression Barométrique : " + String((pressure * 10)*1.029841935058967) + "hPa");
	sendESP8266("GET ***?type=pressure&value="+ String((pressure * 10)*1.029841935058967) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
	receiveESP8266(2000);

}

//Fonction permettant le calcul de l'indice UV

void calcUV() {

	int uv;
	long sum=0;
	
	for(int i=0;i<1024;i++){
		uv = analogRead(PIN_UV);
		sum = uv+sum;
	}

	sum = sum >> 10;
	int uvVoltage = sum*4980.0/1023.0;
	
	if (uvVoltage < 50) {
		Serial.println("-Indice UV : TROP BAS");
	}
	if (uvVoltage > 50 && uvVoltage < 227) {
		Serial.println("-Indice UV : 1");
		sendESP8266("GET ***?type=uvIndex&value=1&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 227 && uvVoltage < 318) {
		Serial.println("-Indice UV : 2");
		sendESP8266("GET ***?type=uvIndex&value=2&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 318 && uvVoltage < 408) {
		Serial.println("-Indice UV : 3");
		sendESP8266("GET ***?type=uvIndex&value=3&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 408 && uvVoltage < 503) {
		Serial.println("-Indice UV : 4");
		sendESP8266("GET ***?type=uvIndex&value=4&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 503 && uvVoltage < 606) {
		Serial.println("-Indice UV : 5");
		sendESP8266("GET ***?type=uvIndex&value=5&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 606 && uvVoltage < 696) {
		Serial.println("-Indice UV : 6");
		sendESP8266("GET ***?type=uvIndex&value=6&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 696 && uvVoltage < 795) {
		Serial.println("-Indice UV : 7");
		sendESP8266("GET ***?type=uvIndex&value=7&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 795 && uvVoltage < 881) {
		Serial.println("-Indice UV : 8");
		sendESP8266("GET ***?type=uvIndex&value=8&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 881 && uvVoltage < 976) {
		Serial.println("-Indice UV : 9");
		sendESP8266("GET ***?type=uvIndex&value=9&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 976 && uvVoltage < 1079) {
		Serial.println("-Indice UV : 10");
		sendESP8266("GET ***?type=uvIndex&value=10&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 1079 && uvVoltage < 1170) {
		Serial.println("-Indice UV : 11");
		sendESP8266("GET ***?type=uvIndex&value=11&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}
	if (uvVoltage > 1170) {
		Serial.println("-Indice UV : 11+");
		sendESP8266("GET ***?type=uvIndex&value=11+&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
		receiveESP8266(2000);
	}

}

//Fonction qui permet de calculer le point de rosée grâce à la température et à l'humidité ambiante

double calcDewPoint(double celsius, double humidity){

   double a = 17.271;
   double b = 237.7;
   double temp = (a * celsius) / (b + celsius) + log(humidity/100);
   double Td = (b * temp) / (a - temp);
   return Td;

}

//Fonction pour la détection d'orage

byte SPItransfer(byte sendByte){

	return SPI.transfer(sendByte);
	
}

//Fonction pour gérer la wifi avec l'ESP8266 (envoyer / recevoir / initialiser)

void sendESP8266(String postData){

	int postDataLength = postData.length();
	Serial2.println("AT+CIPSTART=4,\"TCP\",\"meteo-colmar.fr\",80");
	receiveESP8266(4000);
	Serial2.println("AT+CIPSEND=4,"+ String(postDataLength) +"");
	receiveESP8266(2000);
	Serial2.print(postData);
	receiveESP8266(2000);
	Serial2.println("AT+CIPCLOSE=4");
	receiveESP8266(2000);

}

void receiveESP8266(const int timeout){

	String response = "";
	long int time = millis();
	while( (time+timeout) > millis()){
		while(Serial2.available()){
			char c = Serial2.read();
			response+=c;
		}
	}
	Serial.print(response);

}

void initESP8266(){  

	Serial2.println("AT+RST");
	receiveESP8266(2000);
	Serial2.println("AT+CWMODE=1");
	receiveESP8266(2000);
	Serial2.println("AT+CWJAP=\""+ ESP_SSID +"\",\""+ ESP_WPA +"\"");
	receiveESP8266(10000);
	Serial2.println("AT+CIFSR");
	receiveESP8266(2000);
	Serial2.println("AT+CIPMUX=1");   
	receiveESP8266(5000);
	Serial.println("--ESP prêt à envoyer");

}
