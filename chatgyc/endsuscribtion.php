<?php

function saveUserss($onlineusers_file)
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

function endsusc($user1)
	{
	$curuser=$user1;
    $suscfile=file("suscriber.txt",FILE_IGNORE_NEW_LINES);
    $line=0;
    while($line<count($suscfile))
        {
        $suscfileline=$suscfile[$line];
        $userset=explode(':',$suscfileline,2)[0];
        if($userset==$curuser) 
            {array_splice($suscfile,$line,1);
                $line-=1;
            }
        $line+=1;
        }
    saveUserss($suscfile);
	}



?>