
#include "SPI.h"
#include "Arduino.h"
#include "Wire.h"

#include "RTClib.h"
#include "Adafruit_HDC1000.h"
#include "Adafruit_MPL115A2.h"
#include "PWFusion_AS3935.h"

#define PIN_UV  A1

RTC_DS1307 RTC;
Adafruit_MPL115A2 MPL;
Adafruit_HDC1000 HDC = Adafruit_HDC1000();

void setup() {

	Serial.begin(9600);
	RTC.begin();
	Wire.begin();
	HDC.begin();
	MPL.begin();

    if (! RTC.isrunning()) {
		
		Serial.println("RTC ne fonctionne pas !");
		RTC.adjust(DateTime(__DATE__, __TIME__)); 

		 DateTime now = RTC.now();
		  Serial.print(now.day());
		  Serial.print('/');
		  Serial.print(now.month());
		  Serial.print('/');
		  Serial.print(now.year());  
		  Serial.print(' ');
		  Serial.print(now.hour());
		  Serial.print(':');
		  Serial.print(now.minute());
		  Serial.print(':');
		  Serial.print(now.second());
		  Serial.println();
		  delay(3000);

	}
	
}

void loop() {

	delay(2000);

	float temperature = HDC.readTemperature();
	float humidity = HDC.readHumidity();
	Serial.println("Température : " + String(temperature) + "°C");
	Serial.println("Humidité : " + String(humidity) + "%");

	float pressure = MPL.getPressure();
	int mplTemperature = MPL.getTemperature();
	Serial.println("Température (MPL) : " + String(mplTemperature) + "°C");
	Serial.println("Pression Barométrique : " + String(pressure, 4) + " kPa");
	Serial.println("Pression Barométrique : " + String(pressure * 10) + "hPa");

	int uv;
	long sum=0;
	for(int i=0;i<1024;i++){
		uv = analogRead(PIN_UV);
		sum = uv+sum;
	}

	sum = sum >> 10;
	int uvVoltage = sum*4980.0/1023.0;
	
	if (uvVoltage < 50) {
		Serial.println("Indice UV : TROP BAS");
	}
	if (uvVoltage > 50 && uvVoltage < 227) {
		Serial.println("Indice UV : 1");
	}
	if (uvVoltage > 227 && uvVoltage < 318) {
		Serial.println("Indice UV : 2");
	}
	if (uvVoltage > 318 && uvVoltage < 408) {
		Serial.println("Indice UV : 3");
	}
	if (uvVoltage > 408 && uvVoltage < 503) {
		Serial.println("Indice UV : 4");
	}
	if (uvVoltage > 503 && uvVoltage < 606) {
		Serial.println("Indice UV : 5");
	}
	if (uvVoltage > 606 && uvVoltage < 696) {
		Serial.println("Indice UV : 6");
	}
	if (uvVoltage > 696 && uvVoltage < 795) {
		Serial.println("Indice UV : 7");
	}
	if (uvVoltage > 795 && uvVoltage < 881) {
		Serial.println("Indice UV : 8");
	}
	if (uvVoltage > 881 && uvVoltage < 976) {
		Serial.println("Indice UV : 9");
	}
	if (uvVoltage > 976 && uvVoltage < 1079) {
		Serial.println("Indice UV : 10");
	}
	if (uvVoltage > 1079 && uvVoltage < 1170) {
		Serial.println("Indice UV : 11");
	}
	if (uvVoltage > 1170) {
		Serial.println("Indice UV : 11+");
	}

}


