int LED=6;
void setup() {
Serial.begin(9600); //Serial Communication 
pinMode(LED, OUTPUT );//Declaring pin mode of LED 
} 
void loop() {
while (Serial.available() == 0); //wait until Serial port is open
//digitalWrite( LED, HIGH ); // LED TURNED ON

//read from the serial connection; the - '0' is to cast the values as the int and not the ASCII code
int val = Serial.read() - '0';

//checking value of Serial read
if(val == 1 ){
digitalWrite( LED, HIGH ); // LED TURNED ON
Serial.println("LED is on");
}
if(val == 0 ){
digitalWrite( LED, LOW ); // LOW VOLTAGE - TURNED OFF
Serial.println("LED is off");
}

}
