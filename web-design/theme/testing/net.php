<?php 
use phpseclib3\Net\SSH2;

$ssh = new SSH2('localhost', 22);
if ($expected != $ssh->getServerPublicHostKey()) {
    throw new \Exception('Host key verification failed');
}
?>