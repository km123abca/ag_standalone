<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
  	if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}
$usertype=$fgmembersite->Userrole();
$current_user=$fgmembersite->Userid();
function test_input($data) 
	{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = htmlentities($data);
	return $data;
	}

function get_date($tds)
{
	$monthh = array("01"=>"JAN", "02"=>"FEB", "03"=>"MAR",
    	          "04"=>"APR","05"=>"MAY","06"=>"JUN",
    	          "07"=>"JUL","08"=>"AUG",
    	          "09"=>"SEP","10"=>"OCT","11"=>"NOV",
    	          "12"=>"DEC");
	$tds_split=explode('/',$tds);
    $tds1=$tds_split[0].'-'.$monthh[$tds_split[1]].'-'.$tds_split[2];
    return $tds1;

}

?>
<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('td',$_POST)))
	{

$td="0";
$fd="0";
$td=test_input($_POST["td"]);
$fd=test_input($_POST["fd"]);

$td=get_date($td);
$fd=get_date($fd);
//echo 'tds='.$td;
$days=test_input($_POST["days"]);
$ty=test_input($_POST["ty"]);

$query="insert into leaveapplication (idno,fromdate,todate,days,typ) values (:idno,:fromdate,:todate,:days,:typ) ";
$statemen=oci_parse($conn,$query);
oci_bind_by_name($statemen, ':idno', $current_user);
oci_bind_by_name($statemen, ':fromdate', $fd);
oci_bind_by_name($statemen, ':todate', $td);
oci_bind_by_name($statemen, ':days', $days);
oci_bind_by_name($statemen, ':typ', $ty);
//oci_bind_by_name($statemen, ':idno', $current_user);
oci_execute($statemen);
	}
?>

<head>
			<style>
			.lg
				{
				float:left;
				width:25%;
				}
				lab
				{
					clear: left;
				}
				#ack
				    {
				    color:green;
				    font-size: 1em;
				    text-align: center;

				    }
				#hea
					{
					text-align: center;
					font-size: 1.5em;
					float:left;
					width:100%;
                    font-weight: bold;
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

	<script>
	 function dbwenn(d2,d1)
	        {
	        	var dd2=new Date();
	        	var dd1=new Date();
	        	dd2=d2;
	        	dd1=d1;
                var oneDay=1000*60*60*24;
	        	return (Math.round(Math.abs((dd1.getTime() - dd2.getTime())/(oneDay))));
	        }
	 function stringToDate(str)
	 		{
    		var date = str.split("/"),
        	d = date[0],
            m = date[1],
            y = date[2];
            //console.log(m+" "+d+" "+y);
           return (new Date(y + "-" + m + "-" + d));//.toUTCString();
            }
	 function countdsays()
	 	{
	 		var fd=document.getElementById("fd").value;
	 		var td=document.getElementById("td").value;
	 		fd=stringToDate(fd);
	 		td=stringToDate(td);
	 		//console.log(dbwenn(fds,tds));
	 		 document.getElementById("days").value=dbwenn(fd,td);
	 		
	 	}
	</script>
</head>

<body>

<b2 id="hea">Pending leave applications</b2>
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

$query="select idno,ps_nm,fromdate fd,todate td,aproved,days,typ from leaveapplication,prsnl_infrmtn_systm 
        where ps_idn=idno and ps_idn='$current_user'";
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



<b3 id="hea">New leave application</b3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset>
	<legend>Enter details</legend>
	<lab class="lg bl">From</lab><inp class="lg">:<input type="text" id="fd" name="fd" placeholder="dd/mm/yyyy"></inp>
	<lab class="lg bl">To</lab><inp class="lg">:<input type="text" id="td" name="td" placeholder="dd/mm/yyyy"></inp>
	<lab class="lg bl">No of days</lab><inp class="lg" >:<input type="text" id="days" name="days"
	                                                   placeholder="num?" onfocus="countdsays()"></inp>	
	 <lab class="lg bl">Leave Type</lab><inp class="lg">:
	 <select id="ty" name="ty"  >
     <option value='CL' selected>Casual Leave</option>
     <option value='EL' >Earned Leave</option>
     </select>
	 </inp>
</fieldset>
<input type="submit" name="submit" id="subut" value="Enter" >
</form>
<a href='welcomeuser.php'> Back to Main Page</a>
</body>