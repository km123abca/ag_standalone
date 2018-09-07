 <?php
 include_once('phploc.php');
$message='message';
$user='user';
if (isset($_REQUEST['message']))
$message=strip_tags($_REQUEST['message']);
$message=stripslashes($message);
if (isset($_REQUEST['user']))
$user=$_REQUEST['user'];


$linkdat='none';
if (isset($_REQUEST['linkdat']))
$linkdat=$_REQUEST['linkdat'];
$linkdat='!@#$zhinyat'.$linkdat.'!@#$zhinyat';
if ($linkdat!='!@#$zhinyat'.'none'.'!@#$zhinyat')
$message.=$linkdat;


$room_file=file("room1.txt",FILE_IGNORE_NEW_LINES);

$room_file[]=time()."<!@!>".$user.": ".$message;
if (count($room_file)>20)$room_file=array_slice($room_file,1);
$file_save=fopen("room1.txt","w+");
flock($file_save,LOCK_EX);
for($line=0;$line<count($room_file);$line++){
fputs($file_save,$room_file[$line]."\n");
};
flock($file_save,LOCK_UN);
fclose($file_save);
echo "sentok";
exit();

?>

