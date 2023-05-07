#libraries required
import serial
import time
import sys

start = time.time()#script start timestamp
#port of Arduino serial and bauderate
#ArduinoSerial = serial.Serial('COM5',115200)
ArduinoSerial = serial.Serial('/dev/ttyACM0',115200)
#waiting to have a stable connection
time.sleep(0.1)
keeprunning = True

while keeprunning:
    #script will run for 1/2 sec
    if time.time() - start > 0.55: 
        keeprunning = False
    #flush the serial contents if any
    if(ArduinoSerial.inWaiting()):
        print(ArduinoSerial.readline())
    #sending the command received as argument 1 for the script
    ArduinoSerial.write(sys.argv[1].encode(encoding = 'ascii', errors = 'strict'))
    #wait for data to be sent
    time.sleep(0.1)
#close serial port
ArduinoSerial.close()
#terminate script
exit()

