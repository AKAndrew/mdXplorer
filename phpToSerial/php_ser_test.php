<html>
<head>
<title>PHP serial extension test page</title>
</head>
<body>
<h3>PHP serial extension test page</h3>
<?php
$module = 'win_serial';
 
if (extension_loaded($module)) {
  $str = "Module loaded";
} else {
 $str = "Module $module is not compiled into PHP";
 die("Module $module is not compiled into PHP");
}
 echo "$str<br>";
 
$functions = get_extension_funcs($module);
echo "Functions available in the $module extension:<br>\n";
foreach($functions as $func) {
    echo $func."<br>";
}
echo "<br>";

echo "Version ".ser_version();
echo "<br>";

echo "<br>";

?>
