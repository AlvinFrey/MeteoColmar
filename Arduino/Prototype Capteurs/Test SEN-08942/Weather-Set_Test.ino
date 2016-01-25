//Tester pinMode(pin, INPUT_PULLUP)

//Tester 4 variables (4 valeurs prises) et on regarde si les valeurs augmentent / diminuent (si diminue on envoie la valeur la plus grande)

#define uint  unsigned int
#define ulong unsigned long

#define PIN_ANEMOMETER  2
#define PIN_RAINGAUGE   3  
#define PIN_VANE        A0 

#define MSECS_CALC_WIND_SPEED 5000
#define MSECS_CALC_RAIN_FALL  5000
#define MSECS_CALC_WIND_DIR  5000

volatile int numRevsAnemometer = 0; 
volatile int numDropsRainGauge = 0;
volatile int8_t AS3935_ISR_TRIG = 0;

ulong nextCalcSpeed;    
ulong nextCalcDir;        
ulong nextCalcRain;     
ulong time;        

#define NUMDIRS 8

unsigned long   adc[NUMDIRS] = {26, 45, 77, 118, 161, 196, 220, 256};

char *strVals[NUMDIRS] = {"Ouest","Nord-Ouest","Nord","Sud-Ouest","Nord-Est","Sud","Sud-Est","Est"};

void setup(){

	Serial.begin(9600);

	pinMode(PIN_ANEMOMETER, INPUT);

	digitalWrite(PIN_ANEMOMETER, HIGH);
	digitalWrite(PIN_RAINGAUGE, HIGH);

	attachInterrupt(0, countAnemometer, FALLING);
	attachInterrupt(1, countRainGauge, FALLING);

	nextCalcRain = millis() + MSECS_CALC_RAIN_FALL;
    nextCalcSpeed = millis() + MSECS_CALC_WIND_SPEED;
    nextCalcDir   = millis() + MSECS_CALC_WIND_DIR;

}

void loop(){

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

}

void countAnemometer() {
	numRevsAnemometer++;
}

void countRainGauge() {
	numDropsRainGauge++;
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

	Serial.println("Direction du vent : " + String(strVals[x]));

}


//Calcul la vitesse du vent (1 tour = 2,4km/h)

void calcWindSpeed() {

   long vitesse = 24011;
   vitesse *= numRevsAnemometer;
   vitesse /= MSECS_CALC_WIND_SPEED;

   int x1Vitesse = vitesse / 10;
   int x2Vitesse = vitesse % 10;

   Serial.println("Vitesse du vent : " + String(x1Vitesse) + "." + String(x2Vitesse) + "Km/h");

   numRevsAnemometer = 0; 

}

//Calcul le volume de pluie (1 interruption = 2,794mm d'eau)

void calcRainFall() {

	long volume = 2794;
	volume *= numDropsRainGauge;
	volume /= MSECS_CALC_RAIN_FALL;  

	int x1Volume = volume / 10000;
	int x2Volume = volume % 10000;

	Serial.println("Pluie : " + String(x1Volume) + "." + String(x2Volume) + "mm");
	   
	numDropsRainGauge = 0; 

}
