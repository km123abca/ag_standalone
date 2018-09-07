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
     $_SESSION["repcad"]="";
    if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing1',$_POST)))
	{$_SESSION["repowing"]=$_POST["wing1"];
	 $_SESSION["reposec"]=$_POST["section"];
	 $_SESSION["repobran"]=$_POST["branch"];
	 $_SESSION["repoloc"]=$_POST["loc"];
	 $_SESSION["repcad"]=$_POST["cadre"];
    }
    $wing=$_SESSION["repowing"];
    $section=$_SESSION["reposec"];
    $branch=$_SESSION["repobran"];
     $location=$_SESSION["repoloc"];
     $cadre=$_SESSION["repcad"];
    // $query='select ';
   //  if (strlen($wing)>1) $query.='ps_wing,';
    // if (strlen($section)>1) $query.='ps_sctn_id,';
    // if (strlen($section)>1) $query.='ps_sctn_id,';



     $query="select sec.dmn_dscrptn sectionn, wng.dmn_dscrptn wingg,cdr.dmn_dscrptn cadre,brn.dmn_dscrptn branch,
             count(ps_idn) tot
             from prsnl_infrmtn_systm a,estt_dmn_mstr sec,estt_dmn_mstr wng,estt_dmn_mstr cdr,estt_dmn_mstr brn
			where ps_sctn_id=sec.dmn_id(+) and ps_wing=wng.dmn_id(+)  and ps_cdr_id=cdr.dmn_id(+)
			and ps_brnch_id=brn.dmn_id(+) and ps_flg='W'
			and ps_wing like '$wing' and 
			   ps_sctn_id like '$section' and  ps_cdr_id like '$cadre' and
			   ps_brnch_id like '$branch' and 
			   nvl(ps_room_no,'0') like '$location' 
			   group by sec.dmn_dscrptn, wng.dmn_dscrptn,cdr.dmn_dscrptn,brn.dmn_dscrptn
			   order by sec.dmn_dscrptn, wng.dmn_dscrptn,cdr.dmn_dscrptn,brn.dmn_dscrptn"
			   ;
	?>

<head>
<link rel="STYLESHEET" type="text/css" href="maindb3.css" >
<style>
    table, th, td 
	{
    border: 1px solid black;
     text-align: right;
     border-collapse: collapse;

    }
    button:hover
		   {
            background-color: red;
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
$q2="var queryy ="."\"select sec.dmn_dscrptn sectionn,cdr.dmn_dscrptn cadre,";        
 $q2.=" wng.dmn_dscrptn wingg,brn.dmn_dscrptn branch,count(ps_idn) tot ";
 $q2.=" from prsnl_infrmtn_systm a,estt_dmn_mstr sec,estt_dmn_mstr wng,estt_dmn_mstr cdr,estt_dmn_mstr brn ";
	$q2.=" where ps_sctn_id=sec.dmn_id(,,) and ps_wing=wng.dmn_id(,,) and ps_cdr_id=cdr.dmn_id(,,) ";  
	$q2.=" and ps_brnch_id=brn.dmn_id(,,) and ps_flg='W' and ps_wing like '".$wing ."' and" ;
	$q2.=" ps_sctn_id like '".$section. "' and  ps_flg='W' and "; 
	$q2.=" ps_brnch_id like '". $branch ."' and"; 
	$q2.=" ps_cdr_id like '". $cadre ."' and";
	$q2.=" nvl(ps_room_no,'0') like '".$location."' group by sec.dmn_dscrptn,brn.dmn_dscrptn,";
	$q2.="wng.dmn_dscrptn,cdr.dmn_dscrptn\";"; 
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
	    				"<th><button type=\"button\" onclick=\"rearrange('wng.dmn_dscrptn')\">Wing </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('brn.dmn_dscrptn')\">Branch </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('sec.dmn_dscrptn')\">Section </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('cdr.dmn_dscrptn')\">Cadre </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('count(ps_idn)')\">Count </button></th>"+
	    				"</tr>";
		document.getElementById("inrow").innerHTML=headerText+this.responseText;
		//console.log('this was rec'+this.responseText);
					}
				};
				
		xmlhttp.open("GET", "countsubdisplayhelper.php?q=" + str+"&t="+queryy, true);
		//console.log(str);
        xmlhttp.send();
			}
			
	}
</script>



<body  >
<table id="inrow" >
	<tr>
	    <th><button type="button" onclick="rearrange('wng.dmn_dscrptn')">Wing </button></th>
		<th><button type="button" onclick="rearrange('brn.dmn_dscrptn')">branch</button> </th>
		<th><button type="button" onclick="rearrange('sec.dmn_dscrptn')">Section </button></th>
		<th><button type="button" onclick="rearrange('cdr.dmn_dscrptn')">Cadre </button></th>
		<th><button type="button" onclick="rearrange('count(ps_idn)')">Count </button></th>		
	</tr>
	



	<?php	
	
			//echo '<ee>'.$query.'</ee>';
			 
	 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	if (!$conn)
		{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
		}

		$countquery="select sum(tot) cn from "."($query) aa";
	$statemen=oci_parse($conn,$countquery);
	oci_execute($statemen);
	$countt=0;
    if($row=oci_fetch_array($statemen))
    	$countt=$row["CN"];

	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while($row=oci_fetch_array($statemen))
		{
	
	$sect=$row["SECTIONN"];
    $wng=$row["WINGG"];	
    $branch=$row["BRANCH"];
    $cadree=$row["CADRE"];	
    $tot=$row["TOT"];
	
	echo  "
		  <tr>
		  <td>$wng</td>
		  <td>$branch</td>
		  <td>$sect</td>
		  <td>$cadree</td>
		  <td>$tot</td>
		  </tr>
		 ";
		   
	      
		 
	    }
			
?>
</table>   
<?php
echo "<br>";
echo "<f>Total number of rows:$countt</f>";
?>      
</body>


