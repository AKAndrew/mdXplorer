<?php

// check if cmd parameter exists and length isn't 0 in URL
if(isset($_REQUEST["cmd"]) && strlen($_REQUEST["cmd"])!=0){
	$cmd = intval($_REQUEST["cmd"]);
	// connect to ssh session
	$connection = ssh2_connect('proxy51.rt3.io',34117);
	//$connection = ssh2_connect('akandrew.go.ro',  8008);
	if(!connection) echo "conn error";
	if(!ssh2_auth_password($connection, 'pi', '123abc')){
	//if(!ssh2_auth_password($connection, 'root', '123abc')){
		echo "auth error";
		return; // if auth failed exit&return nothing
	}
}
else return; // exit&return nothing otherwise

// send cmd to Arduino
$command = "python3 pyScript.py {$cmd};";
$stream = ssh2_exec($connection, $command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream); // will receive UP, LEFT etc.
// replace any
$output = str_replace(array("\n", "\t", "\r"), '', $output);
stream_set_blocking($stream, false);

// set timezone for accurate date/time
date_default_timezone_set('Europe/London');
// set command to contain this string
/*$command = 	"echo -e 'Last cmd: ".
// concatenate the formatted date/time
			date("d-m-Y H:i:s",time()).
// concatenate the initial cmd of URL
			" {$output}' ".
// write output of command to lastcommand.txt file 
			"> lastcommand.txt && ".
// append content of lastcommand.txt to commands.txt
			"cat lastcommand.txt >> commands.txt;".
// print conent of lastcommand.txt to console
			"cat lastcommand.txt;";
*/
$command = "echo -e 'Last cmd: %s %s' > lastcommand.txt && cat lastcommand.txt >> commands.txt;cat lastcommand.txt;";
$command = 	sprintf($command, date("d-m-Y H:i:s",time()), $output);


// send command and fetch output
$stream = ssh2_exec($connection, $command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);
stream_set_blocking($stream, false);

// disconnect session and print output
ssh2_disconnect($connection);
echo $output;
?>