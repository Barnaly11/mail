<?php
session_id('b');
session_start();

?>
<DOCTYPE! html>
<html>
	<head>
		<title>Compose</title>
	</head>
	<style type="text/css">
		body{
			background: #333333; /* For browsers that do not support gradients */
  			background: -webkit-linear-gradient( to left , #333333,  #ff3333); /* For Safari 5.1 to 6.0 */
			background: -o-linear-gradient(right , #333333,  #ff3333); /* For Opera 11.1 to 12.0 */
			background: -moz-linear-gradient(right , #333333,  #ff3333); /* For Firefox 3.6 to 15 */
			background: linear-gradient( to right , #333333,  #ff3333); /* Standard syntax */
		}
		#input{
			padding-top: 5%;
			padding-left: 40%;
			background-color: black;
			color: white;
			opacity: 0.8;
			display: block;
			top:2px;

		}
		#submit{
			background-color: white;
			opacity: 0.8;
			display: block;
			padding-left: 40%;
		}
		#submit input{
			background-color: black;
			color: white;
		}
		input{
			border-radius: 5px;
			padding: 10px;
			margin: 5px;
			width: 30%;
		}
		textarea{
			border-radius: 5px;
			padding: 10px;
		}
	</style>
	<body>
		<form action="mm.php" method="post" enctype="multipart/form-data">
			<div id="input">
			<br><input type="email" name="rmail" placeholder="Receiver's email" />
			<br><input type="text" name="subject" placeholder="Subject" />
			<br><textarea type="text" rows=10 columns=40 name=" body" placeholder="Body"></textarea> 
			<br><input type="file" name="attachment[]" multiple />
			</div>
			<div id="submit">
			<input type="submit" name="Send" value="Send" />
			</div>
		</form>
	</body>
</html>