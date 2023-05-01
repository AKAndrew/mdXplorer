#include <FastLED.h>
#include <IRremote.h>

#define LED_PIN     8
#define NUM_LEDS    12
#define phr         A0
#define irPin       7

IRrecv irrecv(irPin);
decode_results results;
CRGB leds[NUM_LEDS];
int light, lightraw, data, cmd;
unsigned int lastfunc=0;
bool newData;

int LED=13; //builtin LED
bool LEDval=0;

void setup() {
  FastLED.addLeds<WS2812, LED_PIN, GRB>(leds, NUM_LEDS);
  pinMode(phr,INPUT);
  
  pinMode(6,OUTPUT);
  pinMode(9,OUTPUT);
  pinMode(10,OUTPUT);
  pinMode(11,OUTPUT);
 
  Serial.begin(115200);
  Serial.setTimeout(1);
  irrecv.enableIRIn();

  pinMode(LED,OUTPUT);
}


 
void loop() {  
  while (Serial.available()){
    data = Serial.read();
    // if we read 'return carrier' or 'newline'
    if(data == 13 || data == 10)
      // end of line, flush buffer
      flushserial();
    else
      cmd = data;
    // mark a new command was received
    newData = 1;
  }

  if(newData){
    newData = 0;
    switch(cmd){
      case '0':
        LEDval = 0;
        break;
      case '1':
        LEDval = 1;
        break;
      case '2':
        forward();
        Serial.println("fwd");
        break;
      case '4':
        left();
        Serial.println("left");
        break;
      case '5':
        Stop();
        Serial.println("stop");
        break;
      case '6':
        right();
        Serial.println("right");
        break;
      case '8':
        back();
        Serial.println("bkwd");
        break;
      default:
        LEDval = !LEDval;
        Serial.println("unkown");
        break;
    }
    digitalWrite(LED, LEDval);
  }

  lightraw = analogRead(phr);
  if(lightraw < 100)
    light = map(lightraw, 100, 0, 0, 255);
  else light = 0;
  light = abs(light);
  for(int i=0; i<12; i++)
    leds[i] = CRGB(light, light, light);
  FastLED.show();
  
   if (irrecv.decode(&results)) {
      Serial.println(results.value);
      switch (results.value) {
         case 16736925: // button Vol+ FORDWARD
            forward();
            break;
         case 16720605: // << LEFT
            left();
            break;
         case 16712445: // >|| STOP
            Stop();
            break;
         case 16761405: // >> RIGHT
            right();
            break;
         case 16754775: // Vol- BACK
            back();
            break;
         case 4294967295:
          switch(lastfunc){
            case 1:
              forward();
              break;
            case 2:
              left();
              break;
            case 3:
              right();
              break;
            case 4:
              back();
              break;
          }
         break;
         default:
         lastfunc = 0;
         break;
         }      
   irrecv.resume();
   }
   delay(100);
}

void flushserial(){
  while(Serial.available() > 0)
    char tmp = Serial.read();
}

void forward()
{
  lastfunc = 1;
  Serial.println("forward");
    digitalWrite(6, HIGH);
    digitalWrite(9, LOW);
    digitalWrite(10, HIGH);
    digitalWrite(11, LOW);
    delay(500);
    Stop();
}

void back()
{
  lastfunc = 4;
  Serial.println("back");
    digitalWrite(6, LOW);
    digitalWrite(9, HIGH);
    digitalWrite(10, LOW);
    digitalWrite(11, HIGH);
    delay(500);
    Stop();
}

void left()
{
  lastfunc = 2;
  Serial.println("left");
    digitalWrite(6, HIGH);
    digitalWrite(9, LOW);
    digitalWrite(10, LOW);
    digitalWrite(11, HIGH);
    delay(250);
    Stop();
}

void right()
{
  lastfunc = 3;
  Serial.println("right");  
    digitalWrite(6, LOW);
    digitalWrite(9, HIGH);
    digitalWrite(10, HIGH);
    digitalWrite(11, LOW);
    delay(250);
    Stop();
} 

void Stop()
{
  Serial.println("stop");
    digitalWrite(6, LOW);
    digitalWrite(9, LOW);
    digitalWrite(10, LOW);
    digitalWrite(11, LOW);
}
