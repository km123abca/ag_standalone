<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if($fgmembersite->Userrole()=='basic')
  {
  	$fgmembersite->RedirectToURL("nomansland.php");
  	exit;
  }

?>
<?php
$ind=1;
if (isset($_REQUEST["m"])) $ind=$_REQUEST["m"];
if(!(file_exists("images/food/a".$ind.".jpg"))) $ind=1;
?>
<head>
<link rel="STYLESHEET" type="text/css" href="maindb3.css" /> 
</head>

<body>
<p><a href='welcomeuser.php'> <f>Main Page</f></a></p>
<a href="photoviewer.php?m=<?php echo ($ind+1);?>">next</a>
<br>
<img src="images/food/a<?php echo $ind;?>.jpg" id="gallery" alt="No Photo" >


</body>