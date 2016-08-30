<?php
session_id('b');
session_start();

$mailboxPath='{imap.gmail.com:993/imap/ssl/novalidate-cert}';
$imap1=imap_open($mailboxPath,$_SESSION['u'],$_SESSION['p']);
$imap=imap_reopen($imap1,$mailboxPath.$_GET['folder']);
$uid=$_GET['uid'];


function getBody($uid, $imap) {
    $body = get_part($imap, $uid, "TEXT/HTML");
    // if HTML body is empty, try getting text body
    if ($body == "") {
        $body = get_part($imap, $uid, "TEXT/PLAIN");
    }
    return $body;
    printf($body);
}

function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
    if (!$structure) {
           $structure = imap_fetchstructure($imap, $uid, FT_UID);
    }
    if ($structure) {
        if ($mimetype == get_mime_type($structure)) {
            if (!$partNumber) {
                $partNumber = 1;
            }
            $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
            
            switch ($structure->encoding) {
                case 3: return imap_base64($text);
                case 4: return imap_qprint($text);
                default: return $text;
           }
       }

        // multipart 
        if ($structure->type == 1) {
            foreach ($structure->parts as $index => $subStruct) {
                $prefix = "";
                if ($partNumber) {
                    $prefix = $partNumber . ".";
                }
                $data = get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                if ($data) {
                    return $data;
                }
            }
        }
    }
    return false;
}

function get_mime_type($structure) {
    $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

    if ($structure->subtype) {
       return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
    }
    return "TEXT/PLAIN";
}
echo '<div id="captchabody">';
//echo "<br><b>Email Body:</b></br>";
//echo getBody($uid,$imap1);
echo "<br>Captcha</br>";
 $overview = imap_fetch_overview($imap1,$uid,0);
        
        /* get mail message */
        $message = imap_fetchbody($imap1, $uid, 2, FT_UID);
        
        /* get mail structure */
        $structure = imap_fetchstructure($imap1, $uid,FT_UID);

        $attachments = array();
        
        /* if any attachments found... */
        if(isset($structure->parts) && count($structure->parts)) 
        {
            for($i = 0; $i < count($structure->parts); $i++) 
            {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );
            
                if($structure->parts[$i]->ifdparameters) 
                {
                    foreach($structure->parts[$i]->dparameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'filename') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }
            
                if($structure->parts[$i]->ifparameters) 
                {
                    foreach($structure->parts[$i]->parameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'name') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }
            
                if($attachments[$i]['is_attachment']) 
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($imap1, $uid, $i+1, FT_UID);
                    
                    /* 4 = QUOTED-PRINTABLE encoding */
                    if($structure->parts[$i]->encoding == 3) 
                    { 
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    /* 3 = BASE64 encoding */
                    elseif($structure->parts[$i]->encoding == 4) 
                    { 
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }
        
        //echo "<br>".sizeof($attachments)."</br>";
        //foreach($attachments as $attachment)
//showing only the first attachment,i.e.,captcha image......
        for($i=1; $i < 2; $i++)
        {
            if($attachments[$i]['is_attachment'] == 1)
            {
                $filename = $attachments[$i]['name'];
                if(empty($filename)) $filename = $attachments[$i]['filename'];
                
                if(empty($filename)) $filename = time() . ".dat";
                //$f=fopen($filename,"w+");
                file_put_contents($filename, $attachments[$i]['attachment']);
                //fwrite($f,$attachment['attachment']);
                //echo "<img src=".$filename." width=20% />";
                //fclose($f);*/
                //echo "\n";
               // echo '<a onclick = window.open("gmail-imap.php") href="gmail-imap.php?func=' . $func . '&folder=' . $folder . '&uid=' . $uid .'&part=' . $attachments[$i]["partNum"] . '&enc=' . $attachments[$i]["enc"] . '">';
                echo "<br>";
                echo "<br><img src=".$attachments[$i]['filename'] ." display=block width=100% />";

                //echo "</a><";
        		echo "</br></div>";
            }
        
        }



?>
<html>
   <head>
      
      <title>Captcha</title>
   </head>

   <style type="text/css">
   		body{
   			background: #333333; /* For browsers that do not support gradients */
  			background: -webkit-linear-gradient( to left , #333333,  #003d99); /* For Safari 5.1 to 6.0 */
			background: -o-linear-gradient(right , #333333,  #003d99); /* For Opera 11.1 to 12.0 */
			background: -moz-linear-gradient(right , #333333,  #003d99); /* For Firefox 3.6 to 15 */
			background: linear-gradient( to right , #333333,  #003d99); /* Standard syntax */
   		}

   		#captchabody{
   			opacity: 0.8;
   			padding: 10px;
   			
   			align-items: center;
   			margin-top: 15%;
   			margin-left: 35%;
   			margin-right: 38%;
   			background-color: white;
   			padding-left: 4%;
   			padding-right:4%;
   		}

   		#captcha{
   			opacity: 0.8;
   			left:center;
   			padding:30px;
   			padding-left: 4%;
   			margin-left: 35%;
   			margin-right: 38%;
   			background-color: black;
   		}
   		#captcha:hover{
   			opacity: 1;
   		}
   </style>

   <body>
   		<div id="captcha">
      <!--<p>Enter the captcha to view the email..</p>-->
      
      <?php echo'<form method="post" action="read.php?folder=' . $folder . '&uid=' . $uid . '&func=read">' ;
      	echo '<input type="text" name="captcha" placeholder="Enter the captcha" />';
        echo '<br></br><input type="submit" value="Send" />';
      echo "</form>";
      ?>
      </div>
   </body>
</html>