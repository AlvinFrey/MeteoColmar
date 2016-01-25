
#include "SoftwareSerial.h"

String ESP_SSID = "***";
String ESP_WPA = "***";
String ESP_RQST_SECRET_KEY = "***";

void setup() {

  Serial.begin(9600);
  Serial2.begin(115200);
  initESP8266();

}

void loop() {

    int fakeTemp = random(27,40);
    sendESP8266("GET ***?type=temperatureFake&value="+ String(fakeTemp) +"&key="+ ESP_RQST_SECRET_KEY +" HTTP/1.1\r\nHost: meteo-colmar.fr\r\nContent-Type: application/x-www-form-urlencoded\r\n\r\n");
    delay(30000);

}

void sendESP8266(String postData){

  int postDataLength = postData.length();
  Serial2.println("AT+CIPSTART=4,\"TCP\",\"meteo-colmar.fr\",80");
  receiveESP8266(4000);
  Serial2.println("AT+CIPSEND=4,"+ String(postDataLength) +"");
  receiveESP8266(2000);
  Serial2.print(postData);
  receiveESP8266(2000);
  Serial.println("============Envoi réussie============");

}

void receiveESP8266(const int timeout){
  String reponse = "";
  long int time = millis();
  while( (time+timeout) > millis())
  {
    while(Serial2.available())
    {
      char c = Serial2.read();
      reponse+=c;
    }
  }
  Serial.print(reponse);
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
  Serial.println("============Module ESP prêt à envoyer============");
}
