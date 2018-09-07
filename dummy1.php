


<?php
require_once("./include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
		{
    $fgmembersite->RedirectToURL("login.php");
    exit;
		}
$current_user=$fgmembersite->Userid();

?>

<head>

</head>

<body>


Hello this is a test file and the the current user is <?php  echo $current_user; ?>

</body>