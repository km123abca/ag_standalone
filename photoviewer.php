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
$ind=10;
$phots=array("rec","hin","ind","hin2","kims");
if (isset($_REQUEST["m"])) $ind=$_REQUEST["m"];
if (isset($_REQUEST["r"])) $x=$_REQUEST["r"];
$phot=$phots[$x];
if(!(file_exists("images/$phot/fil".$ind.".jpg"))) $ind=1;
?>
<head>
<link rel="STYLESHEET" type="text/css" href="maindb3.css" /> 
<style>

#gallery
{
	width: 924px;
	height: 500px;
}
.lef
{
	clear:left;
	float:left;
}
.clle
{
	clear:left;
}
.ri
{
	float:right;
}
p
{
	font-weight: bold;
	color:red;
}
</style>
<script>
 function imageresiz()
 	{
 		h=document.getElementById('gallery').height;
 		w=document.getElementById('gallery').width;
 		//document.getElementById('gallery').style.height=(w+10)+"px";
 		//alert(w);
 	}
</script>
</head>

<body>
<lii class="ri">
<pre>
<p  ><a href='index.php'> Main Page</a></p>

<p  ><a href="photoviewer.php?m=<?php echo ($ind+1);?>&r=<?php echo $x; ?>">next</a></p>
<p  ><a href="photoviewer.php?m=<?php echo ($ind-1);?>&r=<?php echo $x; ?>">previous</a></p>
</pre>
</lii>


<a href="photoviewer.php?m=10&r=<?php echo $x; ?>" >10</a>
<a href="photoviewer.php?m=20&r=<?php echo $x; ?>" >20</a>
<a href="photoviewer.php?m=30&r=<?php echo $x; ?>" >30</a>
<a href="photoviewer.php?m=40&r=<?php echo $x; ?>" >40</a>
<a href="photoviewer.php?m=50&r=<?php echo $x; ?>" >50</a>
<a href="photoviewer.php?m=60&r=<?php echo $x; ?>" >60</a>
<a href="photoviewer.php?m=70&r=<?php echo $x; ?>" >70</a>
<a href="photoviewer.php?m=80&r=<?php echo $x; ?>" >80</a>
<a href="photoviewer.php?m=90&r=<?php echo $x; ?>" >90</a>
<a href="photoviewer.php?m=100&r=<?php echo $x; ?>" >100</a>
<a href="photoviewer.php?m=120&r=<?php echo $x; ?>" >120</a>
<br>


<img src="images/<?php echo $phot; ?>/fil<?php echo $ind;?>.jpg" id="gallery" alt="No Photo" ><!--style="width:720px;height:720px;>-->

<!--  <button type="button" onclick="imageresiz()">click</button>  -->

</body>