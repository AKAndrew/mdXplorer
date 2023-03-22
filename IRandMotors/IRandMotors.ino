#include <IRremote.h>
#define irPin 7
#define m1 6
#define m2 9
#define m3 10
#define m4 11
IRrecv irrecv(irPin);
decode_results results;
unsigned int lastfunc=0;
void setup() {
  pinMode(m1,OUTPUT);
  pinMode(m2,OUTPUT);
  pinMode(m3,OUTPUT);
  pinMode(m4,OUTPUT);
  
  Serial.begin(9600);
  irrecv.enableIRIn();
}
 
void loop() {
   if (irrecv.decode(&results)) {
      Serial.println(results.value);
      switch (results.value) {
         case 16736925:            // button Vol+ FORDWARD
            forward();
            break;
         case 16720605:            // << LEFT
            left();
            break;
         case 16712445:            // >|| STOP
            Stop();
            break;
         case 16761405 :            // >> RIGHT
            right();
            break;
         case 16754775:            // Vol- BACK
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
         }      
   irrecv.resume();
   }
}

void forward()
{
  lastfunc = 1;
  Serial.println("forward");
    digitalWrite(m1, HIGH);
    digitalWrite(m2, LOW);
    digitalWrite(m3, HIGH);
    digitalWrite(m4, LOW);
    delay(500);
    Stop();
}

void back()
{
  lastfunc = 4;
  Serial.println("back");
    digitalWrite(m1, LOW);
    digitalWrite(m2, HIGH);
    digitalWrite(m3, LOW);
    digitalWrite(m4, HIGH);
    delay(500);
    Stop();
}

void left()
{
  lastfunc = 2;
  Serial.println("left");
    digitalWrite(m1, LOW);
    digitalWrite(m2, HIGH);
    digitalWrite(m3, HIGH);
    digitalWrite(m4, LOW);
    delay(250);
    Stop();
}

void right()
{
  lastfunc = 3;
  Serial.println("right");  
    digitalWrite(m1, HIGH);
    digitalWrite(m2, LOW);
    digitalWrite(m3, LOW);
    digitalWrite(m4, HIGH);
    delay(250);
    Stop();
} 

void Stop()
{
  Serial.println("stop");
    digitalWrite(m1, LOW);
    digitalWrite(m2, LOW);
    digitalWrite(m3, LOW);
    digitalWrite(m4, LOW);
}
