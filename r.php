<?php
	session_id('b');
	session_start();
	$imap=imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert}",$_SESSION['u'],$_SESSION['p']);
	$folder=$_GET['folder'];
	echo '<h1>'.$folder.'</h1>';
	$mailboxPath='{imap.gmail.com:993/imap/ssl/novalidate-cert}';
				if(!imap_reopen($imap,$mailboxPath.$folder))
				{
					echo "--------------error!!--------------";
					
				}
				else
				{
				$numMessages = imap_num_msg($imap);
				if ($numMessages>10) 
				{
				for ($i = $numMessages; $i > ($numMessages - 20); $i--) 
				{
    					$header = imap_header($imap, $i);

    					$fromInfo = $header->from[0];
    					$replyInfo = $header->reply_to[0];

    					$details = array("fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
            				? $fromInfo->mailbox . "@" . $fromInfo->host : "",
        					"fromName" => (isset($fromInfo->personal))
            				? $fromInfo->personal : "",
        					"replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
            				? $replyInfo->mailbox . "@" . $replyInfo->host : "",
        					"replyName" => (isset($replyTo->personal))
            				? $replyto->personal : "",
        					"subject" => (isset($header->subject))
            				? $header->subject : "",
        					"udate" => (isset($header->udate))
            				? $header->udate : ""
    					);

    					$uid = imap_uid($imap, $i);
    					if (preg_match('/ISI/',$details["subject"]))
    					{

	    					echo '<div class="mails">';
	    					echo "<div>";
	    					echo '<a class="m" href="mail.php?folder=' . $folder . '&uid=' . $uid . '&func=delete"><img src="http://www.freeiconspng.com/uploads/remove-icon-png-25.png" /></a>';
	    					echo "</div>";
	    					echo '<a href="prompt.php?folder=' . $folder . '&uid=' . $uid . '&func=read">';
	    					echo "<strong>From:</strong>" . $details["fromName"];
	    					echo " | " . $details["fromAddr"] . "</br>";
	    					echo "<strong>Subject:</strong> " . $details["subject"] . "";
	    					//echo '<a href="read.php?folder=' . $folder . '&uid=' . $uid . '&func=read">Read</a>';
	    					echo " </a>";
	    					
	    					echo "</div>";
	    				}
	    				else{
	    					echo '<div class="mails">';
	    					echo "<div>";
	    					echo '<a class="m" href="mail.php?folder=' . $folder . '&uid=' . $uid . '&func=delete"><img src="http://www.freeiconspng.com/uploads/remove-icon-png-25.png" /></a>';
	    					echo "</div>";
	    					echo '<a href="read1.php?folder=' . $folder . '&uid=' . $uid . '&func=read">';
	    					echo "<strong>From:</strong>" . $details["fromName"];
	    					echo " | " . $details["fromAddr"] . "</br>";
	    					echo "<strong>Subject:</strong> " . $details["subject"] . "";
	    					//echo '<a href="read.php?folder=' . $folder . '&uid=' . $uid . '&func=read">Read</a>';
	    					echo " </a>";
	    					
	    					echo "</div>";
	    				}
					}
				}
				else
				{
					for ($i = $numMessages; $i > 0; $i--) {
    					$header = imap_header($imap, $i);

    					$fromInfo = $header->from[0];
    					$replyInfo = $header->reply_to[0];

    					$details = array("fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
            				? $fromInfo->mailbox . "@" . $fromInfo->host : "",
        					"fromName" => (isset($fromInfo->personal))
            				? $fromInfo->personal : "",
        					"replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
            				? $replyInfo->mailbox . "@" . $replyInfo->host : "",
        					"replyName" => (isset($replyTo->personal))
            				? $replyto->personal : "",
        					"subject" => (isset($header->subject))
            				? $header->subject : "",
        					"udate" => (isset($header->udate))
            				? $header->udate : ""
    					);

    					$uid = imap_uid($imap, $i);
    					//$_SESSION['uid']=$uid;
    					//$_SESSION['imap']=$imap;
    					if (preg_match('/ISI/',$details["subject"]))
    					{
	    					echo '<div class="mails">';
	    					echo "<div>";
	    					echo '<a class="m" href="mail.php?folder=' . $folder . '&uid=' . $uid . '&func=delete"><img src="http://www.freeiconspng.com/uploads/remove-icon-png-25.png" /></a>';
	    					echo "</div>";
	    					echo '<a href="prompt.php?folder=' . $folder . '&uid=' . $uid . '&func=read">';
	    					echo "<strong>From:</strong>" . $details["fromName"];
	    					echo " | " . $details["fromAddr"] . "</br>";
	    					echo "<strong>Subject:</strong> " . $details["subject"] . "";
	    					//echo '<a href="read.php?folder=' . $folder . '&uid=' . $uid . '&func=read">Read</a>';
	    					echo "</a>";
	    					
	    					echo "</div>";
						}
						else
						{
							echo '<div class="mails">';
	    					echo "<div>";
	    					echo '<a class="m" href="mail.php?folder=' . $folder . '&uid=' . $uid . '&func=delete"><img src="http://www.freeiconspng.com/uploads/remove-icon-png-25.png" /></a>';
	    					echo "</div>";
	    					echo '<a href="read1.php?folder=' . $folder . '&uid=' . $uid . '&func=read">';
	    					echo "<strong>From:</strong>" . $details["fromName"];
	    					echo " | " . $details["fromAddr"] . "</br>";
	    					echo "<strong>Subject:</strong> " . $details["subject"] . "";
	    					//echo '<a href="read.php?folder=' . $folder . '&uid=' . $uid . '&func=read">Read</a>';
	    					echo "</a>";
	    					
	    					echo "</div>";
						}
					}
				}
			}
	
?>
<DOCTYPE! html>
<html>
	<head>
		<title>profile</title>
	</head>
	<style type="text/css">
		body{
			background-color: ;
		}
		.mails{
			margin: 5px;
			padding: 5px;	
			margin-bottom: 8px;		
			border-radius: 5px;
			/* box-shadow: 0px 0px 5px black;*/
			background-color: white;
			color:black;
			opacity: 0.9;
			outline: none;
			color: black;
			border-left: solid 15px black;
			border-bottom: solid 5px white;
			border-top: solid 5px white;
			background-color:;
		}
		.mails:hover{
			box-shadow: 0px 0px 10px black;
			background-color: #cccccc;
		}
		.mails div{
			
			margin: 0px;
			padding: 0px;
			perspective-origin: -10px;
			object-position: 0px;
			position: relative;
		}
		img{
			width: 20px;
			height: 20px;
			/*box-shadow: 2px 2px 5px black;*/
		}
		.m{
			float: right;
			
		}
		a{
			text-decoration: none;
			color: black;
		}
	</style>
	<body>
	</body>
</html>