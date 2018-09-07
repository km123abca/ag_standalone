<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>
<?php
    if(!isset($_SESSION['toggle'])) $_SESSION['toggle']='desc';
     $_SESSION["repowing"]="";
     $_SESSION["reposec"]="";
     $_SESSION["repobran"]="";
     $_SESSION["repoloc"]="";
     $_SESSION["startd"]="";
     $_SESSION["endd"]="";
    if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing1',$_POST)))
	{$_SESSION["repowing"]=$_POST["wing1"];
	 $_SESSION["reposec"]=$_POST["section"];
	 $_SESSION["repobran"]=$_POST["branch"];
	 $_SESSION["repoloc"]=$_POST["loc"];
	 $_SESSION["startd"]=$_POST["sdate"];
	 $_SESSION["endd"]=$_POST["edate"];
    }
    $wing=$_SESSION["repowing"];
    $section=$_SESSION["reposec"];
    $branch=$_SESSION["repobran"];
     $location=$_SESSION["repoloc"];

     $dd=$_POST['sdate'];
     $ed=$_POST['edate'];
     if ((($_POST["sdate"]==""))) $dd='01/01/1900';
     if ((($_POST["edate"]==""))) $ed=date('d-m-Y');//date('d-m-Y');
     //echo "date:$ed";
     
     $sdate='to_date(\''.$dd.'\',\'DD/MM/YY\')';
     $edate='to_date(\''.$ed.'\',\'DD/MM/YY\')';
    // $defdate='to_date(\''.$_POST["edate"].'\',\'DD/MM/YY\')';
     //echo $sdate.' '.$edate;
     $query="select ps_idn idd,ps_nm namee,ps_floor levell,sec.dmn_dscrptn sectionn,wng.dmn_dscrptn wingg,
              sr_dt_of_jn_cag retdate from prsnl_infrmtn_systm a,estt_dmn_mstr sec,estt_dmn_mstr wng
			where ps_sctn_id=sec.dmn_id(+) and ps_wing=wng.dmn_id(+) 
			and nvl(sr_dt_of_jn_cag,sysdate) between $sdate and $edate
			and ps_flg='W' 
			and ps_wing like '$wing' and 
			   ps_sctn_id like '$section' and 
			   ps_brnch_id like '$branch' and 
			   nvl(ps_room_no,'0') like '$location'";
	?>

<head>
<style>
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

	
	body
	{
	background-image:url('scania.jpg');
	}
	#inrow
	{
	background-color:yellow;
	}
	ee
	{
	background-color:yellow;
	}
</style>
  

</head>

<script>
<?php
$q2= "var queryy =";
$q2="var queryy ="."\"select ps_idn idd,ps_nm namee,ps_floor levell,sec.dmn_dscrptn sectionn,wng.dmn_dscrptn wingg ,";
     $q2.=" sr_dt_of_jn_cag retdate from ";
    $q2.=" prsnl_infrmtn_systm a,estt_dmn_mstr sec,estt_dmn_mstr wng";
	$q2.=" where ps_sctn_id=sec.dmn_id(,,) and ps_wing=wng.dmn_id(,,)";
	//$q2.=" and last_day(add_months(ps_dt_of_brth,720))>sysdate and ps_dt_of_brth is not null ";
	$q2.=" and sr_dt_of_jn_cag between ".$sdate." and ".$edate;
	$q2.=" and ps_flg='W' and ps_wing like '".$wing ."' and" ;
	$q2.=" ps_sctn_id like '".$section. "' and"; 
	$q2.=" ps_brnch_id like '". $branch ."' and"; 
	$q2.=" nvl(ps_room_no,'0') like '".$location."'\";"; 
			   echo $q2;
?>
function rearrange(str)
	{//console.log(queryy);
		//document.getElementById("wing").value=document.getElementById("wing1").value;
		
		if (str.length!=0)
			{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
				{
		if (this.readyState == 4 && this.status == 200)
					{    //console.log('The resposeText received is this '+this.responseText);
	    var headerText="<tr>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_idn')\">Office Id</button> </th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_nm')\">Name </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_floor')\">Level </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_sctn_id')\">Section </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_wing')\">Wing </button></th>"+
	    				"<th><button type=\"button\" onclick=#>DOJ </button></th>" +
	    				"</tr>";
		document.getElementById("inrow").innerHTML=headerText+this.responseText;
		//console.log('this was rec'+this.responseText);
					}
				};
				
		xmlhttp.open("GET", "zorarepo_v2_helper.php?q=" + str+"&t="+queryy, true);
		//console.log(str);
        xmlhttp.send();
			}
			
	}
</script>



<body  >
<table id="inrow" >
	<tr>
		<th><button type="button" onclick="rearrange('ps_idn')">Office Id</button> </th>
		<th><button type="button" onclick="rearrange('ps_nm')">Name </button></th>
		<th><button type="button" onclick="rearrange('ps_floor')">Level </button></th>
		<th><button type="button" onclick="rearrange('ps_sctn_id')">Section </button></th>
		<th><button type="button" onclick="rearrange('ps_wing')">Wing </button></th>
		<th><button type="button" onclick=#>DOJ </button></th>
	</tr>
	



	<?php	
	
			//echo '<ee>'.$query.'</ee>';
			 
	$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	if (!$conn)
		{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
		}
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while($row=oci_fetch_array($statemen))
		{
	$psidn=$row["IDD"];
	$psnm=$row["NAMEE"];
	$psfloor=$row["LEVELL"];
	$sect=$row["SECTIONN"];
    $wng=$row["WINGG"];	
    $dor=$row["RETDATE"];
	
	echo  "
		  <tr>
		  <td>$psidn</td>
		  <td>$psnm</td>
		  <td>$psfloor</td>
		  <td>$sect</td>
		  <td>$wng</td>
		  <td>$dor</td>
		  </tr>
		 ";
		   
	      
		 
	    }
			
?>
</table>        
</body>


