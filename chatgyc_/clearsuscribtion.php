<?php

function saveUsers($onlineusers_file)
	{
	$file_save=fopen("suscriber.txt","w+");
	flock($file_save,LOCK_EX);
	for($line=0;$line<count($onlineusers_file);$line++)
		{
		fputs($file_save,$onlineusers_file[$line]."\n");
		};
	flock($file_save,LOCK_UN);
	fclose($file_save);
	}

if (isset($_REQUEST['user'])
	{
		$cur_user=$_REQUEST['user'];
		$susc_file=file("suscriber.txt",FILE_IGNORE_NEW_LINES);
		
	}

?>