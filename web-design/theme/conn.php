<?php
$output = "plm";
$command = "echo -e 'Last cmd: %s %s' ";
$command = 	sprintf($command, date("d-m-Y H:i:s",time()), $output);
//$command = 	sprintf($test, "@@", $output);
echo $command;
?>