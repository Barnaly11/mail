<?php
session_id('b');
session_start();
$_SESSION['u']=$_POST['user'];
$_SESSION["p"]=$_POST['pass'];

//set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
$mailboxPath="{imap.gmail.com:993/imap/ssl/novalidate-cert}";
$username=$_POST['user'];
$password=$_POST['pass'];
$imap = imap_open($mailboxPath, $username, $password);
$folders = imap_list($imap, $mailboxPath, "*");
echo '<div class="h"><STRONG>EMAIL</STRONG></div>';

echo '<div class="c"><a href="compose.php" target="iframe1"><b>Compose</b></a></div>';
echo "<ul>";
foreach ($folders as $folder) 
{
    $folder = str_replace($mailboxPath, "",$folder);
    echo '<div class ="folder"><a href="r.php?folder='.$folder.'&func=view" target="iframe1">' . $folder . '</a></div>';

    //include "r.php";
   }
echo "</ul>";

?>


<DOCTYPE! html>
<html>
	<head>
		<title>profile</title>
	</head>
	<style type="text/css">
		p{
			float: right;
		}
		body{
			background-color:#ffffb3 ;
		}
		ul{
			top:15%;
			position: absolute;
			position: fixed;
		}
		.folder{
			
			padding: 5px;
			margin: 10px;
			width: 130px;
			font-size: 18px;
			background-color: #333333;
			box-shadow: 0px 0px 10px  black;
			color: white;
			border-radius: 5px;
		}
		.folder:hover{
			/*background-color:#ff8080;
			color: black;*/
			width: 140px;
			text-decoration-color: white;
			box-shadow: 0px 5px 10px black;
			border-radius: 5px;
			left:4%;
		}
		a{
			text-decoration: none;
			color:#e6e6e6;
			
		}
		iframe:focus {
    		outline: none;
		}
		.h{
			top:0px;
			left:0px;
			right: 0px;
			color: white;
			position: absolute;
			height: 10%;
			background-color: #333333;
			/*opacity: 0.8;*/
			text-align: center;
			position: fixed;
			z-index: 1;
		}
		iframe[seamless] {
    		display: block;
    		background-color: white;
    		border-left: solid 10px #333333;
		}
		iframe{
			background-color: white;
			border-left: solid 10px #333333;
			border-top:none; 
		}
		.c{
			background-color:#0073e6;
			color: black;
			padding: 5px;
			border-radius: 5px;
			text-align: center;
			font-size: 18px;
			top:10%;
			width: 140px;
			position: absolute;
			position: fixed;
			padding-left:10px;
			padding-right: 10px;
			left: 3.8%; 
			margin-top:10px;
		}
		.c:hover{
			box-shadow: 0px 10px 10px  black;
		}
		.c a{
			color: black;
		}
	</style>
	<body>
	<iframe src="r.php" name="iframe1" scrolling="auto"; style="float:right; width:79.1%; height: 100%; background-color:; position: absolute;top:10%; left: 20%; "></iframe>
	</body>
</html>