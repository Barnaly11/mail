<?php
	
// Create a blank image and add some text
$im = imagecreatetruecolor(100, 40);
//set the text color
$text_color = imagecolorallocate($im, 500, 14, 91);
//$val=(bin2hex(openssl_random_pseudo_bytes(rand(4,6))));
$captchanumber = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
//getting the first 6 values after shuffling captchanumber
$val=substr(str_shuffle($captchanumber), 0, 6);
$_SESSION['c']=$val;
//placing the val in the image 
imagestring($im, 10, 20, 10,  $val , $text_color);
// Save the image as 'simpletext.jpg'
imagejpeg($im, 'captcha.jpg',100);
// Free up memory
imagedestroy($im);
//displaying the image
//echo "<br><img src=captcha.jpg width=20% />";

?>