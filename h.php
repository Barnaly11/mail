<?php
	session_id('b');
	session_start();
	//header('Cache-Control: must-revalidate');

	if(isset($_SESSION['u']))
	{
		header('Location: profile.php');
	}
?>
<DOCTYPE! html>
<html>
<head>
<title>User Authentication</title>
</head>
<style type="text/css">
	* {
 		 margin: 0;
  		padding: 0;
  		border: 0;
  		text-decoration: none;
  		outline: none;
}

	body{
		background-image: url('http://hdwallpaperbackgrounds.net/wp-content/uploads/2016/01/Cat-With-Glasses-HD-Wallpaper-Desktop-BAckground.jpg');
		background-position: 58% 25%;
		/*opacity: 0.5;*/
	}
	.d{
		position: absolute;
		margin: auto;
		top:50%;
		left: 33%;
		background-color: white;
		opacity: 0.5;
		padding: 70px;
		z-index: -1;
		/*background:#FF5335;*/
	}
	.f1{
		width: 300px;
		height: 300px;
		border-radius: 10
		padding:70px;
		margin: 0px;
		/*background-color: red;*/
		opacity: 1;
		background: black;
		opacity: 1;
		box-shadow: 5px 5px 20px #000;

	}
	.f{
		top:70%;
		left: 40%;
		position: absolute;
		/*box-shadow: 2px 2px 3px #000;*/
	}
	.i1,.i2{
		top:500px;
		left: 31%;
		padding: 15px;
		margin: 10px;
		border-radius: 5px;
		width: 250px;
		
	}
	.i1:focus{
		box-shadow: 0px 1px 2px #fff;

	}
	.i2:focus{
		box-shadow: 0px 1px 2px #fff;

	}
	.i3{
		margin: 5px;
		width: 100px;
		padding: 10px;
		border-radius: 10%;
		margin-top: 30px;
		margin-left: 30%;
		background-color:   #a9e343  ;
		outline: none;
		font-size: 15px;
		text-shadow: 1px 1px 2px #000;
  		box-sizing: border-box;
  		opacity: 0.8;
  		color: black;
  		text-align: center;
  		box-shadow: 0px 0px 0px #a2d0f7;
  		cursor: pointer;
	}
	.i3:hover{
		opacity: 1;

	}
	input{
		text-decoration: none;
	}
	
</style>
<body>

<div class="d">
	<div class="f1">

	</div>
</div>
	<div class="f">
		<form action="profile.php" method="post" >
			<input type="text" name="user" placeholder="email" class="i1"/><br />
			<input type="password" name="pass" placeholder="password" class="i2" /><br />
			<input type="submit" name="submit" value="Login" class="i3" />
		</form>
	</div>
</body>
</html>