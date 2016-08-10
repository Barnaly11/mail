<?php
session_id('b');
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
require_once "Mail.php";
//require "h.php";
$host = "ssl://smtp.gmail.com";
$username = $_SESSION['u'];
$password = $_SESSION['p'];
$port = "465";
$to = $_POST['rmail'];
$email_from = $username;
$email_subject = $_POST['subject'];

$email_address = $_POST['rmail'];
$file=fopen($_POST['file'], 'r');
//$email_body = array('body' =>$_POST['body'],'file'=>$file);
$email_body=$_POST['body'];
$headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
$mail = $smtp->send($to, $headers, $email_body);


if (PEAR::isError($mail)) {
//echo("<p>" . $mail->getMessage() . "</p>");
	echo "</p>error..Message not sent..</p>";
} else {
echo("<p>Message successfully sent!</p>");
//header("location".".php");
}
?>
<DOCTYPE! html>
<html>
<head>
<title>Mail SEnt</title>
</head>
<body>
	
</body>
</html>