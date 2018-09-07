<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if($fgmembersite->Userrole()!='all')
  {
  	$fgmembersite->RedirectToURL("nomansland.php");
  	exit;
  }
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
  	if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}
				$current_user=$fgmembersite->Userid();
?>
<head>
		<script >
	     function hidee()
	     {
	     	document.getElementById("ack").style.visibility="hidden";
	     	document.getElementById("ack").style.position="absolute";
	        document.getElementById("ack").style.float="left";
	     }
		</script>
<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('apy0',$_POST)))
		{echo "<button type='button' id='ack' onclick='hidee()'>approvals/denials confirmed, 
	           click here to hide notification</button>";
		$cn=0;
		while(array_key_exists("apy$cn",$_POST))
			{
		
		$pid=$_POST["idinp$cn"];
		$pfid=$_POST["fdinp$cn"];
		$ptid=$_POST["tdinp$cn"];
		$papy=$_POST["apy$cn"];
		//$papn=$_POST["apn$cn"];
        $apr=$papy;
		$query="update leaveapplication set  aproved='$apr' where 
		        idno='$pid' and
		        todate='$ptid' and
		        fromdate='$pfid' ";
		$statemen=oci_parse($conn,$query);
		/*
		oci_bind_by_name($statemen, ':idno', $current_user);
		oci_bind_by_name($statemen, ':fromdate', $fd);
		oci_bind_by_name($statemen, ':todate', $td);*/
		oci_execute($statemen);


        $cn+=1;
			}

		}

?>


				<style>
				#ack
				    {
				    color:green;
				    font-size: 1em;
				    text-align: center;

				    }
				#hea
					{
					text-align: center;
					font-size: 2.5em;
					}

				.bl
					{
					font-weight: bold;
					}
				table#t01 
					{
    				width: 100%; 
    				background-color: #f1f1c1;
					}
					th
					{
					text-align: left;
					}
					table#t01 tr:nth-child(even) 
					{
    				background-color: #eee;
					}
					table#t01 tr:nth-child(odd) 
					{
    				background-color: #fff;
					}
					table#t01 th 
					{
    				color: white;
    				background-color: black;
					}
					.novis
					{
				    visibility: hidden;
				    width:2px;
					}
				</style>
				<h1 id="hea">Leave applications pending approval</h1>
</head>

<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="t01">
<tr>
<th><b1 class="bl"> ID Number</b1></th>
<th><b1 class="bl"> Name</b1></th>
<th><b1 class="bl"> From Date</b1></th>
<th><b1 class="bl"> To Date</b1></th>
<th><b1 class="bl"> Number of Days</b1></th>
<th><b1 class="bl"> Leave Type</b1></th>
<th><b1 class="bl"> Approved?</b1></th>
</tr>

<?php

$query="select idno,ps_nm,fromdate fd,todate td,aproved,days,typ from leaveapplication,prsnl_infrmtn_systm where ps_idn=idno";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$count=0;
while( $row=oci_fetch_array($statemen))
		{
$idno=$row["IDNO"];
$nm=$row["PS_NM"];
$fd=$row["FD"];
$td=$row["TD"];
$ap=$row["APROVED"];
$days=$row["DAYS"];
$typ=$row["TYP"];
$chn="checked";
$chy="";
if($ap=='y') 
	{
	$chy="checked";
	$chn="";
	}

echo "<tr>";

echo "<td><inp id='id$count' name='id$count'> $idno</inp>";
echo "<input id='idinp$count' name='idinp$count' class='novis' type='text' value='$idno'></td>";

echo "<td><inp id='nm$count' name='nm$count'> $nm</inp>";
echo "<input id='nminp$count' name='nminp$count' type='text' class='novis' value='$nm'></td>";

echo "<td><inp id='fd$count' name='fd$count'> $fd</inp>";
echo "<input id='fdinp$count' name='fdinp$count' type='text' class='novis' value='$fd'></td>";

echo "<td><inp id='td$count' name='td$count'> $td</inp>";
echo "<input id='tdinp$count' name='tdinp$count' type='text' class='novis' value='$td'></td>";

echo "<td><inp id='days$count' name='days$count'> $days</inp>";
echo "<input id='daysinp$count' name='daysinp$count' type='text' class='novis' value='$days'></td>";

echo "<td><inp id='typ$count' name='typ$count'> $typ</inp>";
echo "<input id='typinp$count' name='typinp$count' type='text' class='novis' value='$typ'></td>";

echo "<td>yes<input type='radio' id='apy$count' name='apy$count' value='y' $chy>";
echo "no<input type='radio' id='apn$count' name='apy$count' value='n' $chn></td>";
echo "</tr>";
$count+=1;
		}
?>
</table>


<input type="submit" name="submit" id="subut" value="confirm approval/denial" >
</form>
<a href='welcomeuser.php'> Back to Main Page</a>
</body>