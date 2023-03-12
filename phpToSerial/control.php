<html>
<head>
<?php
$module = 'win_serial';
if (!extension_loaded($module))
 die("Module $module is not compiled into PHP");

ser_open( "COM6", 9600, 8, "None", "1", "None" );
if (!ser_isopen())
	echo "Port is not open!";

if(isset($_GET['ledVal']))
	if(ser_isopen())
		ser_write($_GET['ledVal']);


echo "Received: ".ser_read();

// $str="";
// while(ser_inputcount())
	// $str = ser_read();

// if(strlen($str))
	// echo "Received: ".$str;
?>
<style>
#container{
	width:50%;
	margin:0 auto;
}
.btn{
	color:white;
	border:none;
	background-color:#009900;
	height:40%;
	font-size:1000%;
	width:100%;	
	float:right;
	margin-top:10%;
}
</style>
</head>

<body>
<center><h1>PHP to Arduino Serial comm.</h1>
<h3>LED switch on/off</h3></center>
<form id="container">
<button class="btn" name="ledVal" value="1" >On</button>
<button class="btn" name="ledVal" value="0">Off</button>
</form>
</body>
</html>
