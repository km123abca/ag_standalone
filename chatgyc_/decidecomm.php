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
  
if (isset($_REQUEST['sender'],$_REQUEST['receiver']))
		{
		$sender=$_REQUEST['sender'];
		$receiver=$_REQUEST['receiver'];
		$susc_file=file("suscriber.txt",FILE_IGNORE_NEW_LINES);
		$susc_file[]=$sender.':'.$receiver;
		if ($sender==$receiver)
			{
			 echo 'same_user';
			 exit();
			}
		saveUsers($susc_file);
		echo $receiver;
		}

?>