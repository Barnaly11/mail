<?php
session_id('b');
session_start();
$mailboxPath='{imap.gmail.com:993/imap/ssl/novalidate-cert}';

/**
 *	Gmail attachment extractor.
 *
 *	Downloads attachments from Gmail and saves it to a file.
 *	Uses PHP IMAP extension, so make sure it is enabled in your php.ini,
 *	extension=php_imap.dll
 *
 */
 
 
set_time_limit(3000); 
 

/* connect to gmail with your credentials */
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = $_SESSION['u']; # e.g somebody@gmail.com
$password = $_SESSION['p'];
$uid=$_GET['uid'];

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
$imap=imap_reopen($inbox,$mailboxPath.$_GET['folder']);
//$inbox=imap_reopen($inbox,$hostname.$_GET['folder']);
/* get all new emails. If set to 'ALL' instead 
 * of 'NEW' retrieves all the emails, but can be 
 * resource intensive, so the following variable, 
 * $max_emails, puts the limit on the number of emails downloaded.
 * 
 */
/* useful only if the above search is set to 'ALL' */

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox, $uid ,0);
        
        /* get mail message */
        $message = imap_fetchbody($inbox, $uid ,2, FT_UID );
        
        /* get mail structure */
        $structure = imap_fetchstructure($inbox, $uid, FT_UID);

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
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $uid, $i+1, FT_UID);
                    
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
        
        /* iterate through each attachment and save it */
        foreach($attachments as $attachment)
        {
            if($attachment['is_attachment'] == 1)
            {
                $filename = $attachment['name'];
                if(empty($filename)) $filename = $attachment['filename'];
                
                if(empty($filename)) $filename = time() . ".dat";
                
                /* prefix the email number to the filename in case two emails
                 * have the attachment with the same file name.
                 */
                //$fp = fopen("./" . $email_number . "-" . $filename, "w+");
                //fwrite($fp, $attachment['attachment']);
               /* $f=fopen($filename,"w+");
                fwrite($f,$attachment['attachment']);
                echo "<img src=".$filename." width=20% />";
                //fclose($fp);
                fclose($f);*/


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    echo ($attachment['attachment']);
    exit;
//}
            }
        
        }
    

?>