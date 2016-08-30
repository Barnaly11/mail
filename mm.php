<?php
	session_id('b');
	session_start();

	require_once "Mail.php";
  require_once "Mail/mime.php";

	$host = "ssl://smtp.gmail.com";
	$username = $_SESSION['u'];
	$password = $_SESSION['p'];
	$port = "465";
	$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password)); 
	   
	$to = $_POST['rmail'];
    $from = $_SESSION['u'];
    $subject1[]="ISI ";
    $subject1[]= $_POST['subject'];
    $subject=implode(": ", $subject1);
    $headers = array(
      'To' => $to,
      'From' => $from,
      'Subject' => $subject
    );
   
    $html = "".$_POST['body']."\n";
    $mime = new Mail_mime();


    //captha attachment........
    require_once 'captchaimage.php';
  	$mime->AddAttachment('captcha.jpg','image/jpeg');


//rc4 
    require_once 'rc4.php';
    $html1=rc4($_SESSION['c'],$html);//encrypt
    //$html2=rc4($_SESSION['c'],$html1);//decrypt
    //$html3[]=$html1;
    //$html3[]=$html2;
    //$html4=implode('........................', $html3);
    $mime -> setTXTBody($html1);
    $mime -> setHTMLBody($html1);


   for($i=0; $i< count($_FILES['attachment']['name']); $i++ )
    {
    	if (is_uploaded_file ($_FILES['attachment']['tmp_name'][$i])) 
    	{
  			$mime->AddAttachment($_FILES['attachment']['name'][$i],$_FILES['attachment']['type'][$i]);
  		}
  	}
 
    $body = $mime -> get();
    $headers = $mime -> headers($headers);

    $mail = $smtp -> send($to, $headers, $body);
    if(PEAR::isError($mail)) {
	  echo $mail->getMessage();
	  echo  "Message not sent.";
    echo '<br><a href="compose.php">Try Again!</a>';
	} else {
	  //echo 'Message sent.......';
    
    echo  "Message sent.";
    echo '<br><a href="compose.php">Got another mail to send?</a>';
	 }
?>