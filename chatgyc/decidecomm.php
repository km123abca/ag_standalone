<?php

function saveUsers($susc_file)
	{
	$file_save=fopen("suscriber.txt","w+");
	flock($file_save,LOCK_EX);
	for($line=0;$line<count($susc_file);$line++)
		{
		fputs($file_save,$susc_file[$line]."\n");
		};
	flock($file_save,LOCK_UN);
	fclose($file_save);
	}
//generates a list of users with whom the current user communicates
function genuserlist($param)
    {
    $susc_file=file("suscriber.txt",FILE_IGNORE_NEW_LINES);
    $resp='';
    for ($i=0;$i<count($susc_file);$i++)	
    	{
    	$senderr=explode(':',$susc_file[$i],2);
    	if (isset($senderr[0])) $s=$senderr[0];
		if (isset($senderr[1])) $r=$senderr[1];
		if ($s==$param) 
			{
			$resp.=$r.',';
		    }
    	}
    	$resp=substr($resp, 0,strlen($resp)-1);
    	return $resp;
    }

    //THis line is added to unhook all restricted comms
if (isset($_REQUEST['cs']))
	{
		$sender=$_REQUEST['cs'];
		$susc_file=file("suscriber.txt",FILE_IGNORE_NEW_LINES);
		$line=0;
		while($line<count($susc_file))
		{
		$senderr=explode(':',$susc_file[$line],2);
		$s='none';$r='none';
		if (isset($senderr[0])) $s=$senderr[0];
		if (isset($senderr[1])) $r=$senderr[1];
		if ($s==$sender)
			{
			array_splice($susc_file,$line,1);
			$line-=1;
			}
		$line+=1;
		}
		saveUsers($susc_file);
		echo 'cleared';
	}
  
if (isset($_REQUEST['sender'],$_REQUEST['receiver']))
		{
		$sender=$_REQUEST['sender'];
		$receiver=$_REQUEST['receiver'];
		$susc_file=file("suscriber.txt",FILE_IGNORE_NEW_LINES);

        //New content:Content added to check whether suscrubtion already exists
        $flag=false;$line=0;
        
		while($line<count($susc_file))
		{
		$senderr=explode(':',$susc_file[$line],2);
		$s='none';$r='none';
		if (isset($senderr[0])) $s=$senderr[0];
		if (isset($senderr[1])) $r=$senderr[1];
		if (($s==$sender)&&($r==$receiver))
			{
			$flag=true;
			array_splice($susc_file,$line,1);
			$line-=1;
			}
		$line+=1;
		}
		if ($flag)
           {
           	saveUsers($susc_file);
           	echo genuserlist($sender);
			exit();
           }
         //New content:ends

		$susc_file[]=$sender.':'.$receiver;
		if ($sender==$receiver)
			{
			 echo 'same_user';
			 exit();
			}
		saveUsers($susc_file);
		echo genuserlist($sender);
		}

?>