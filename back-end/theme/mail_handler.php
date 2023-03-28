<?php 
if(isset($_POST['submit'])){
	ini_set( 'display_errors', 1 );
	error_reporting( E_ALL );
    $to = "mdxplorer@gymvibeiasi.ro"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $name = $_POST['name'];
    $subject = "mdXplorer contact form submission from ".$_POST["name"];
    $subject2 = "Copy of your mdXplorer contact form submission";
	$message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];
    $message = $name . " wrote the following:" . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
	if(mail($to,$subject,$message,$headers) && mail($from,$subject2,$message2,$headers2))
		header('Location: contact.html#success');
	else
		header('Location: contact.html#failed');
}
?>