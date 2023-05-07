<?php
// connect to ssh
$connection = ssh2_connect('akandrew.go.ro',  8008);
ssh2_auth_password($connection, 'root', '123abc');

date_default_timezone_set('Europe/London');
// get the q parameter from URL
$command = isset($_REQUEST["cmd"])?$_REQUEST['cmd']:'NONE';
$command = "echo -e '".date("d-m-Y H:i:s",time())." {$command}<br/>' >> commands.txt && cat commands.txt";
//echo $command;

// send command and fetch output
$stream = ssh2_exec($connection, $command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);
ssh2_disconnect($connection);
echo "<p>" . $output . "</p>";
?>