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
			padding: 5px;
			margin-left: 35%;
			margin-right: 35%;
			padding-left:2%; 
			background-color: black;
			color: white;
			opacity: 1;
			display: block;
			top:2px;

		}
		.rs{
			width: 80%;
			margin: 0px;
			border-left:solid 10px #ff3333;
		}
		#submit{
			background-color: white;
			opacity: 1;
			display: block;
			margin-left: 35%;
			margin-right: 35%;
			padding-left: 10%;

		}
		#submit input{
			background-color: black;
			color: white;
			padding: 5px;
			margin: 10px;
			text-align: center;
			
		}
		input{
			border-radius: 5px;
			padding: 10px;
			/*margin: 5px;*/
			width: 30%;
			border-left: 10px;
		}
		textarea{
			margin-top: 5px;
			padding: 10px;
			border-radius: 5px;
			border-left:solid 10px grey;

		}
		#form{
			
			margin-top: 5%;
		}
	</style>
	<body>
		<form id="form" action="mm.php" method="post" enctype="multipart/form-data">
			<div id="input">
			<br><input class="rs" type="email" name="rmail" placeholder="Receiver's email" />
			<br><input class="rs" type="text" name="subject" placeholder="Subject" />
			<br><textarea type="text" rows=10 cols=35 name=" body" placeholder="Body"></textarea> 
			<br><input type="file" name="attachment[]" multiple />
			</div>
			<div id="submit">
			<input type="submit" name="Send" value="Send" />
			</div>
		</form>
	</body>
</html>