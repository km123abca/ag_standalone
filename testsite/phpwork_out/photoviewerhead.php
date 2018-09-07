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

<head>
<style>
				.lg
				  {
				  	float:left;
				  	width:50%;
				  	color:blue;
				  }
				  #container1
				  {
				  	background-color: gray;
				  	position: relative;
				  	left:10%;
				  	top:30%;
				  	width:50%;
				  }
				  legend
				  {
				  	font-weight: bold;
				  }
				  .cl
				  {
				  	clear: both;
				  }
				  .graybak
				  {
				  	background-color: #b3b4aa;
				  }
				  .offheading
				  {
				  	text-align: center;
				  	width:100%;
				  	color:blue;
				  }
				  
</style>
<h1 class="offheading">Links to Photos</h1>
</head>

<body class="graybak">
<fieldset id="container1">
	<legend> Index</legend>
	<b1 class="lg"><a href="photoviewer.php?m=1&r=0">Recreation Club Function 2017 Novembor</a></b1>
	<b1 class="lg cl"><a href="photoviewer.php?m=1&r=1">Hindi Fortnight 2017</a></b1>
	<b1 class="lg cl"><a href="photoviewer.php?m=1&r=2">Independence day 2017</a></b1>
</fieldset>
<p><a href='welcomeuser.php'> <f>Main Page</f></a></p>
</body>
