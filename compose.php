<?php
session_id('b');
session_start();
if(isset($_FILES) && (bool)$_FILES)
{
	$allowedextentions=array("pdf","doc","docx","gif","jpeg" );
	foreach ($_FILES as $name => $file) {
		$file_name=$file['name'];
		$temp_name=$file['tmp-name'];
		$path_parts=pathinfo($file_name);
		$ext=$path_parts['extension'];
		if (!in_array($ext, $allowedextentions)) {
			# code...
			die("extensions not allowed");
		}

	}
	$semi_rand=md5(time());
	$mime_boundary="==Multipart_Boundary_x{$semi_rand}x";
	$headers="\nMIME-Version:1.0\n";
	$headers="Content-Type:multipart/mixed;\n";
	$headers="boundary=\"{mime_boundary}\"";
}
?>
<DOCTYPE! html>
<html>
	<head>
		<title>Compose</title>
	</head>
	<body>
		<form action="m.php" method="post" enctype="multipart/form-data">
			<input type="email" name="rmail" placeholder="Receiver's email" />
			<input type="text" name="subject" placeholder="Subject" />
			<input type="textarea" rows=10 columns=40 name=" body" placeholder="Body" />
			<input type="file" name="file" value="Attachments" />
			<input type="submit" name="Send" value="Send" />
		</form>
	</body>
</html>