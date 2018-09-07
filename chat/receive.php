<?php
$lastreceived=$_REQUEST['lastreceived'];
$room_file=file("room1.txt",FILE_IGNORE_NEW_LINES);
for($line=0;$line<count($room_file);$line++){
$messageArr=explode("<!@!>",$room_file[$line]);
if($messageArr[0]>$lastreceived)echo $messageArr[1]."<br>";
}
if (isset($messageArr[0]))
echo "<SRVTM>".$messageArr[0];
else
echo "<SRVTM>".'0';


?>
