<?php
// check if cmd parameter exists and length isn't 0 in URL
/*if(isset($_REQUEST["cmd"]) && strlen($_REQUEST["cmd"])!=0){
	// connect to ssh session
	//$connection = ssh2_connect('proxy55.rt3.io',  32809);
	$connection = ssh2_connect('akandrew.go.ro',  8008);
	if(!$connection){
		echo "conn error";
		//return;
	}
	else 
	if(!ssh2_auth_password($connection, 'pi', '123abc')){
		echo "auth error";
		//return; // if auth failed exit&return nothing
	}
}
else{
	echo "cmd = ".$_REQUEST["cmd"] ;
	//return; // exit&return nothing otherwise
}*/

	//$connection = ssh2_connect('proxy55.rt3.io',  32809);
	$connection = ssh2_connect('akandrew.go.ro',  8008);
	ssh2_auth_password($connection, 'pi', '123abc')

// set timezone for accurate date/time
date_default_timezone_set('Europe/London');
// set command to contain this string
$command = 	"echo -e 'Last cmd: ".
// concatenate the formatted date/time
			date("d-m-Y H:i:s",time()).
// concatenate the initial cmd of URL
			" {$_REQUEST["cmd"]}' ".
// write output of command to lastcommand.txt file 
			"> lastcommand.txt && ".
// append content of lastcommand.txt to commands.txt
			"cat lastcommand.txt >> commands.txt; ".
// print conent of lastcommand.txt to console
			"cat lastcommand.txt; ";
// send command and fetch output
ssh2_exec($connection, $command);
echo $command;
$command = "python3 pyScript.py {$_REQUEST['cmd']} && exit;"
ssh2_exec($connection, $command);
echo $command;
//stream_set_blocking($stream, true);
//$output = stream_get_contents($stream);
//ssh2_disconnect($connection); // disconnect session
//echo $output;
*/
?>