<?php
session_id('b');
session_start();
echo $_SESSION['u'];


 //var $dirPath,$deleteEmails=false;
    //var $imapInBox;
    /*function __construct($mailHost,$emailLogin,$pass) {
        $this->imapInBox=imap_open($mailHost,$emailLogin,$pass) or die("Unable to connect:".imap_last_error());
    }*/
    function getdecodevalue($msg,$bodyType) {
        if($bodyType==0 || $bodyType==1) {
            $msg = imap_base64($msg);
        }
        if($bodyType==2) {
            $msg = imap_binary($msg);
        }
        if($bodyType==3 || $bodyType==5) {
            $msg = imap_base64($msg);
        }
        if($bodyType==4) {
            $msg = imap_qprint($msg);
        }
        return $msg;
    }

    function downLoadAttachment($dirPath,$deleteEmails=false) {
    	$mailboxPath='{imap.gmail.com:993/imap/ssl/novalidate-cert}.$folder';
$imap2=imap_open($mailboxPath,$_SESSION['u'],$_SESSION['p']);
        $nAttachment = 0;
        $dirPath = str_replace('\\', '/', $dirPath);
        if (substr($dirPath, strlen($dirPath) - 1) != '/') {
            $dirPath .= '/';
        }
        $message = array();
        $message["attachment"]["type"][0] = "text";
        $message["attachment"]["type"][1] = "multipart";
        $message["attachment"]["type"][2] = "message";
        $message["attachment"]["type"][3] = "application";
        $message["attachment"]["type"][4] = "audio";
        $message["attachment"]["type"][5] = "image";
        $message["attachment"]["type"][6] = "video";
        $message["attachment"]["type"][7] = "other";
       
        //$nEmails = imap_search($this->imapInBox, 'ALL', SE_UID);
        //$j=-1;
        //for ($j = 0; $j < count($nEmails); $j++) {
            //$j++;
            $messStructure = imap_fetchstructure($imap2, $uid , FT_UID);
            /*$overview = imap_fetch_overview($this->imapInBox,$j ,0);
        echo '<span>Read/Unread'.($overview[0]->seen ? 'read' : 'unread').'</span>';
        echo  '<span>Subject:: '.$overview[0]->subject.'</span> ';
        echo  '<span>From:: '.$overview[0]->from.'</span>';
        echo '<span>On:: '.$overview[0]->date.'</span>';*/
            $body = imap_fetchbody($imap2,$uid,2,FT_UID);
            echo $body;
            if(isset($messStructure->parts)) {
                $parts = $messStructure->parts;
                $fpos=2;
                for($i = 1; $i < count($parts); $i++) {
                $message["pid"][$i] = ($i);
                $part = $parts[$i];
                if(isset($part->disposition) && $part->disposition == "ATTACHMENT") {
                    $message["type"][$i] = $message["attachment"]["type"][$part->type] . "/" . strtolower($part->subtype);
                    $message["subtype"][$i] = strtolower($part->subtype);
                    $fileName=$part->dparameters[0]->value;
                    $mess = imap_fetchbody($imap2,$j+1,$fpos); 
                    $fp=fopen($dirPath.$fileName, 'w');
                    $data=getdecodevalue($mess,$part->type); 
                    echo $data;  
                    var_dump($data);
                    fwrite($fp,$data);
                    fclose($fp);
                    $nAttachment++;
                    $fpos+=1;
                     return ("Completed ($nAttachment attachment(s) downloaded into $dirPath)");
                }
            }
        }
    }
                
        


$dirPath=$_SERVER['DOCUMENT_ROOT']."/gmail/";

echo downLoadAttachment($dirPath);
?>