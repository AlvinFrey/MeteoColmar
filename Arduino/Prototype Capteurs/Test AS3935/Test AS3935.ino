 
#include <SPI.h>
#include <AS3935.h>

void printAS3935Registers();

byte SPItransfer(byte sendByte);

void AS3935Irq();
volatile int AS3935IrqTriggered;

AS3935 AS3935(SPItransfer,10,2);

void setup()
{
  Serial.begin(9600);

  SPI.begin();
  SPI.setDataMode(SPI_MODE1);
  SPI.setClockDivider(SPI_CLOCK_DIV16);
  SPI.setBitOrder(MSBFIRST);

  AS3935.reset();

  AS3935.tune(5);

  AS3935.setIndoors();

  AS3935.enableDisturbers();
  printAS3935Registers();
  AS3935IrqTriggered = 0;

  attachInterrupt(5,AS3935Irq,RISING);

}

void loop()
{

  if(AS3935IrqTriggered){

    AS3935IrqTriggered = 0;

    int irqSource = AS3935.interruptSource();

    if (irqSource & 0b0001)
      Serial.println("Noise level too high, try adjusting noise floor");
    if (irqSource & 0b0100)
      Serial.println("Disturber detected");
    if (irqSource & 0b1000)
    {
      int strokeDistance = AS3935.lightningDistanceKm();
      if (strokeDistance == 1)
        Serial.println("Storm overhead, watch out!");
      if (strokeDistance == 63)
        Serial.println("Out of range lightning detected.");
      if (strokeDistance < 63 && strokeDistance > 1)
      {
        int energy = AS3935.lightningEnergy();
        Serial.print("Lightning detected ");
        Serial.print(strokeDistance,DEC);
        Serial.println(" kilometers away.");
      }
    }
  }
}

void printAS3935Registers()
{
  int noiseFloor = AS3935.getNoiseFloor();
  int spikeRejection = AS3935.getSpikeRejection();
  int watchdogThreshold = AS3935.getWatchdogThreshold();
  Serial.print("Noise floor is: ");
  Serial.println(noiseFloor,DEC);
  Serial.print("Spike rejection is: ");
  Serial.println(spikeRejection,DEC);
  Serial.print("Watchdog threshold is: ");
  Serial.println(watchdogThreshold,DEC);  
}

byte SPItransfer(byte sendByte)
{
  return SPI.transfer(sendByte);
}

void AS3935Irq()
{
  AS3935IrqTriggered = 1;
}