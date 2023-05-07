<html>
<head>
</head>
<?php

// ssh protocols
// note: once openShell method is used, cmdExec does not work

class ssh2 {

  private $host = 'akandrew.go.ro';
  private $user = 'root';
  private $port = '8008';
  private $password = '123abc';
  private $con = null;
  private $shell_type = 'xterm';
  private $shell = null;
  private $log = '';

  function __construct($host='', $port=''  ) {

     if( $host!='' ) $this->host  = $host;
     if( $port!='' ) $this->port  = $port;

     $this->con  = ssh2_connect($this->host, $this->port);
     if( !$this->con )
       $this->log .= "Connection failed !"; 
	}

  function authPassword( $user = '', $password = '' ) {

     if( $user!='' ) $this->user  = $user;
     if( $password!='' ) $this->password  = $password;

     if( !ssh2_auth_password( $this->con, $this->user, $this->password ) )
       $this->log .= "Authorization failed !"; 
  }

  function openShell( $shell_type = '' ) {

        if ( $shell_type != '' ) $this->shell_type = $shell_type;
    $this->shell = ssh2_shell( $this->con,  $this->shell_type );
    if( !$this->shell ) $this->log .= " Shell connection failed !";

  }

  function writeShell( $command = '' ) {
    fwrite($this->shell, $command.PHP_EOL);
  }

  function cmdExec( ) {

        $argc = func_num_args();
        $argv = func_get_args();

    $cmd = '';
    for( $i=0; $i<$argc ; $i++) {
        if( $i != ($argc-1) ) {
          $cmd .= $argv[$i]." && ";
        }else{
          $cmd .= $argv[$i];
        }
    }
    echo $cmd;
    $stream = ssh2_exec( $this->con, $cmd );
    stream_set_blocking( $stream, true );
	return stream_get_contents($stream);
  }

  function getLog() {
     return $this->log; 
  }

}

?>
<body>
	<div class="shell">
	<?php
// get the q parameter from URL
$command = isset($_REQUEST["cmd"])?$_REQUEST['cmd']:'';
$command = "echo ".date("d-m-Y H:i:s",time())." {$command} >> commands.txt";
echo $command;
$connection = ssh2_connect('akandrew.go.ro',  8008);
ssh2_auth_password($connection, 'root', '123abc');
$stream = ssh2_exec($connection, 'ls -la /tmp');
stream_set_blocking($stream, true);
echo "<br/>Output: <p>" . stream_get_contents($stream). '<br/>';
	?>
	</div>
	<form action="" method="GET">
		<input type="text" name="input" placeholder="Type command..."/>
		<button type="submit" name="send" value="Send">Send</button>
		<button type="submit" name="clear" value="Clear">Clear</button>
	</form>
</body>
</html>