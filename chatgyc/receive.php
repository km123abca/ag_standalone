<?php

function comb_suscfile($user,$we)
   {
    if ($user==$we) return true;
   	$susc_file=file("suscriber.txt",FILE_IGNORE_NEW_LINES);
   	$returnItem=true;
   	for($line=0;$line<count($susc_file);$line++)
   	    {
        $parts=explode(":",$susc_file[$line]);
        if (($parts[0]==$user)&&($parts[1]==$we)) 
        	return true;
        elseif ($parts[0]==$user)
        	$returnItem=false;
        }
     return $returnItem;
   }

function checkforsuscribtion($message,$we)
	{
		$user=explode(':',$message,2)[0];
		//$message=explode(':',$message[0],2)[1];
        if (comb_suscfile($user,$we)) return true;
        return false;
	}

$sendr=$_REQUEST['sendr'];
$lastreceived=$_REQUEST['lastreceived'];
$room_file=file("room1.txt",FILE_IGNORE_NEW_LINES);
for($line=0;$line<count($room_file);$line++)
	{
	$messageArr=explode("<!@!>",$room_file[$line]);
	if(($messageArr[0]>$lastreceived) && (checkforsuscribtion($messageArr[1],$sendr)))
		echo "<b>".explode(':',$messageArr[1],2)[0]."</b>:".explode(':',$messageArr[1],2)[1]."<br>";
	}
if (isset($messageArr[0]))
echo "<SRVTM>".$messageArr[0];
else
echo "<SRVTM>".'0';


?>
