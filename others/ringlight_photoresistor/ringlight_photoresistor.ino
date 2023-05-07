#include <FastLED.h>

#define LED_PIN     6
#define NUM_LEDS    12
#define LED         5
#define phr         A0

CRGB leds[NUM_LEDS];
bool LEDval = 0;
int light, lightraw;
void setup() {
  //initializing the LED model, pin, number of individual LEDS
  FastLED.addLeds<WS2812, LED_PIN, GRB>(leds, NUM_LEDS);
  pinMode(LED,OUTPUT);
  pinMode(phr,INPUT);
  Serial.begin(9600);
}

void loop() {
  lightraw = analogRead(phr);
  if(lightraw < 300)
    light = map(lightraw, 300, 0, 0, 255);
  else light = 0;
  light = abs(light);
  for(int i=0; i<12; i++)
    leds[i] = CRGB(light, light, light);
  FastLED.show();
  digitalWrite(LED,LEDval);
  delay(100);
}
