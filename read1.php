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
//require_once 'rc4.php';
$plain=getBody($uid,$imap1);
//$plain=rc4($_POST['captcha'],$cipher);

echo '<div id="body"><h4><b>'.($plain).'<b><h4></div>';

function getAttachments($imap, $mailNum, $part, $partNum) {
    $attachments = array();

    if (isset($part->parts)) {
        foreach ($part->parts as $key => $subpart) {
            if($partNum != "") {
                $newPartNum = $partNum . "." . ($key + 1);
            }
            else {
                $newPartNum = ($key+1);
            }
            $result = getAttachments($imap, $mailNum, $subpart,
                $newPartNum);
            if (count($result) != 0) {
                 array_push($attachments, $result);
             }
        }
    }
    else if (isset($part->disposition)) {
        if ($part->disposition == "ATTACHMENT") {
            $partStruct = imap_bodystruct($imap,FT_UID,
                $partNum);
            $attachmentDetails = array(
                "name"    => $part->dparameters[0]->value,
                "partNum" => $partNum,
                "enc"     => $partStruct->encoding
            );
            return $attachmentDetails;
        }
    }

    return $attachments;
}
$mailStruct = imap_fetchstructure($imap1, $uid,FT_UID);
$attachments = getAttachments($imap1, $uid, $mailStruct, "");
//echo "<br>".sizeof($attachments);
if ($attachments['is_attachment']==1) {
    
    echo "<br>Attachments: ";
    for($i=0; $i<sizeof($attachments) ; $i++) 
    {

    echo '<a onclick = window.open("gmail-imap.php") href="gmail-imap.php?func=' . $func . '&folder=' . $folder . '&uid=' . $uid .
        '&part=' . $attachments[$i]["partNum"] . '&enc=' . $attachments[$i]["enc"] . '">' .
        $attachments[$i]["name"]." <br> " . "</a>";
    }
}

// displaying the attachment(s);


        $overview = imap_fetch_overview($imap1,$uid,0);
        //echo "<br>".$overview."</br>";
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
        for($i=0; $i < sizeof($attachments); $i++)
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
                echo '<a onclick = window.open("gmail-imap.php") href="gmail-imap.php?func=' . $func . '&folder=' . $folder . '&uid=' . $uid .
    '&part=' . $attachments[$i]["partNum"] . '&enc=' . $attachments[$i]["enc"] . '">';
            echo '<div id="img">';
                echo "<img src=".$attachments[$i]['filename'] ." display=block width=20% />";
                echo '<br><p>'.$attachments[$i]["name"].'</p></br>';
                echo "</a>";
            echo '</div>';
            }
        
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Body</title>
</head>
<style>
    body{
            background: #333333; /* For browsers that do not support gradients */
            background: -webkit-linear-gradient( to left , #333333,  #00cc66); /* For Safari 5.1 to 6.0 */
            background: -o-linear-gradient(right , #333333,  #00cc66); /* For Opera 11.1 to 12.0 */
            background: -moz-linear-gradient(right , #333333,  #00cc66); /* For Firefox 3.6 to 15 */
            background: linear-gradient( to right , #333333,  #00cc66); /* Standard syntax */
        }
    #body{
        color: white;
        opacity: 0.6;
        background-color: black;
        padding: 2%;
        border-left:ridge 40px green;
    }
    a{
        text-decoration: none;.
        color: black;
    }
    p{
        color: black;
    }
    #img{
        opacity: 0.9;
        display: block;
        background-color:transparent;
        margin: 0px;
        padding: 5%;

    }
</style>
<body>

</body>
</html>