<?php
session_id('b');
session_start();
//ini_set('session.cache_limiter','public');
//header('Expires: 0');
//header('Cache-Control: no-cache');
//header('Pragma: private');
//session_cache_limiter(false);
//$_SESSION['u']=$_POST['user'];
//$_SESSION["p"]=$_POST['pass'];
$_SESSION['u']=isset($_POST['user'])?$_POST['user']:$_SESSION['u'];
$_SESSION["p"]=isset($_POST['pass'])?$_POST['pass']:$_SESSION["p"];
//set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
$mailboxPath="{imap.gmail.com:993/imap/ssl/novalidate-cert}";
$username=$_SESSION['u'];
$password=$_SESSION["p"];
$imap = imap_open($mailboxPath, $username, $password);
$folders = imap_list($imap, $mailboxPath, "*");
echo '<div class="h"><p><STRONG>EMAIL</STRONG></p></div>';

echo '<div class="c"><a href="compose.php" ><b>Compose</b></a></div>';
echo "<ul>";
foreach ($folders as $folder) 
{
    $folder = str_replace($mailboxPath, "",$folder);
    echo '<div class ="folder" ><a href="r.php?folder='.$folder.'&func=view" target="iframe1">' . $folder . '</a></div>';

    //include "r.php";
   }
echo '<div class="folder"><a href="logout.php">Log Out</a></div>';
echo "</ul>";
echo '<div id="bg"><img src="http://freetopwallpaper.com/wp-content/gallery/sakura/sakura-flowers-wallpaper-hd-10.jpg" style="border-left:solid 50px #333333;"/></div>';
//echo '<div id="mails">';
//include 'r.php';
//echo "</div>";
?>


<DOCTYPE! html>
<html>
	<head>
		<title>profile</title>
	</head>
	<style type="text/css">
		body{
			
			margin: 0px;
			padding: 0px;
		}
		#bg img{
			top: 25%;
			width: 100%;
			z-index: -1;
			width: 96.1%;
			position: fixed;
			position: absolute;
		}
		#bg{
			top:;
			width: 96%;
		}
		p{
			float: right;
		}
		#mails{
			top:25%;
			margin: 0px;
			padding: 0px;
			position: absolute;
			right: 0%;
			width: 100%;
			outline: none;
			border:none;
			opacity: 0.8;
			height: 100%;
			left: 5%;
		}
		body{
			/*background-color:#ffffb3 ;*/
			
		}

		ul{
			left: 0px;
			top:7%;
			background-color: orange;
			position: fixed;
			z-index: 1;
			right: 0px;
			border-top: solid 50px white;
			border-bottom: solid 20px white;
			opacity: 0.9;
		}
		.folder{
			left: 0px;
			display: inline;
			padding:6px;
			margin: 5px;
			width: 130px;
			font-size: 16px;
			text-align: center;
			background-color: #333333;
			box-shadow: 0px 0px 10px  black;
			color: white;
			border-radius: 5px;
			

		}
		.folder:hover{
			/*background-color:#ff8080;
			color: black;*/
			top:6%;
			text-decoration-color: white;
			box-shadow: 0px 5px 10px black;
			/*border-bottom: solid 5px black;*/
			border-top: solid 10px black;
			border-radius: 5px;
			left:4%;
			opacity: 1;
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
			align: center;
			position: fixed;
			z-index: 1;
			opacity:1;
		}
		.h p{
			left: 50%;
			position: absolute;
		}
		
		
		.c{
			background-color:#4da6ff;
			color: black;
			padding: 5px;
			border-radius: 5px;
			text-align: center;
			
			top:1%;
			width: 60px;
			position: absolute;
			position: fixed;
			padding-left:10px;
			padding-right: 10px;
			right: 3.8%; 
			margin-top:10px;
			margin-right:0%; 
			z-index: 1;
			
		}
		.c:hover{
			box-shadow: 0px 10px 10px  black;
			background-color: #66b3ff;
		}
		.c a{
			color: black;
		}
		#mails a{
			color: black;
		}
		iframe:focus {
    		outline: none;
    		border-style: none;
    		boder:none;
		}
		iframe{
			border:none;
		}
		iframe[seamless] {
		    display: block;
		    outline: none;
		    border-style: none;
		    border:none;
		}
	</style>
	<body>
	<iframe src="r.php" name="iframe1" scrolling="auto" id="mails"  style="float:right:; width:96%; height: 100%; background-color:; position: absolute;top:25%; left: 4%; "></iframe>
	</body>
</html>