<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>

<head>
<link rel="STYLESHEET"  href="maindb3.css" />
<style >
	table, th, td 
	{
    border: 1px solid black;
     text-align: right;
     border-collapse: collapse;

    }
    tr:hover {background-color: #f5f5f5;}
    tr:nth-child(even) {background-color: #f2f2f2;}
    th {
    background-color: #4CAF50;
    color: white;

       }
       #varbo2
       {
       	visibility: hidden;
       }
</style> 
<script>
function hidestuff()
	{
	document.getElementById("form1").style.visibility="hidden";
	document.getElementById("form1").style.position="absolute";
	document.getElementById("form1").style.float="left";
	/*
	document.getElementById("q").style.visibility="hidden";
	document.getElementById("q").style.position="absolute";
	document.getElementById("q").style.float="left";
	*/
	document.getElementById("varbo").style.float="right";
	document.getElementById("varbo2").style.float="right";
	document.getElementById("varbo2").style.visibility="visible";
	document.getElementById("varbo").style.clear="left";
	}
</script>
</head>

<body>

<form method="post" id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<f>Employee Name</f>		: <input type="text" name="empname" id="empname" list="sectionlist" size="40">
<datalist id="sectionlist">
<?php
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
$query="select distinct ps_nm from sctn_hstry_dummy order by ps_nm";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
while ($row = oci_fetch_array($statemen))
	{
$nm=$row["PS_NM"];
echo "<option value='$nm'>";
	}
?>
</datalist>
<input type="submit" name="submit" value="execute" >
<button type="button" onClick="hidestuff()">hide</button>
</form>
<p id='varbo'><a href='welcomeuser.php'> <f>Main Page</f></a></p>
<p id='varbo2'><a href='section_history.php'> <f>Show</f></a></p>

<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('empname',$_POST)))
			{
$name2search="noone";
$name2search=$_POST["empname"];

echo "<table>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Section</th>";
echo "<th>From</th>";
echo "<th>To</th>";
echo "</tr>";
$query="select * from sctn_hstry_dummy where ps_nm ='$name2search'";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
while ($row = oci_fetch_array($statemen))
				{
$nm=$row["PS_NM"];
$sctn=$row["SCTN"];
$from=$row["PS_FRM_DT"];
$to=$row["PS_TO_DT"];

echo "<tr>";
echo "<td>$nm</td>";
echo "<td>$sctn</td>";
echo "<td>$from</td>";
echo "<td>$to</td>";
echo "</tr>";
				}
echo "</table>";
			}
?>
</body>