<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

function eluc($n)
	{
		$x=$n;
		$y=floor($x/365);
		$x=$x%365;
		$m=floor($x/30);
		$x=$x%30;

		$retstr=floor($n).'days ('.$y.' years '.$m.' months '.$x.' days)';

		return $retstr;


	}

?>

<head>
<h1 style="width:100%;text-align: center;">Section History of Employees</h1>
<link rel="STYLESHEET"  href="maindb3.css" />
<style >
	
    table#stab tr:hover {background-color: #f5f5f5;}
   
    body
    {
    	background-color: #d9b38c;
    }

    table#stab
              {
                width: 100%; 
                background-color: #f1f1c1;
              }
              th
              {
              text-align: left;
              }
              table#stab tr:nth-child(even) 
              {
                background-color: #eee;
              }
              table#stab tr:nth-child(odd) 
              {
                background-color: #fff;
              }
              table#stab th 
              {
                color: white;
                background-color: black;
              }

       #varbo2
       {
       	visibility: hidden;
       }
       #b2
       {
       	font-weight: bold;
       	font-size:20px;
       	font-style: italic;
       	width: 100%;
       	text-align: center;
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
<f>Employee Name</f>		: <input type="text" name="empname" id="empname" list="sectionlist" size="40" value=<?php echo '\''.$fgmembersite->SafeDisplay('empname').'\'';?>  >
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
<input type="submit" name="submit" value="Get Section History" >
<button type="button" onClick="hidestuff()">hide</button>
</form>
<p id='varbo'><a href='empreports.php'> <f>Main Page</f></a></p>
<p id='varbo2'><a href='section_history.php'> <f>Show</f></a></p>

<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('empname',$_POST)))
			{
$name2search="noone";
$name2search=$_POST["empname"];

$name2search_ns=str_replace(' ','',$name2search);



$prequery="select to_char(min(nvl(pm_dt_of_prmtn,sysdate)),'dd/mm/yyyy') pd
		   from   estt_prmtn,
		   		  prsnl_infrmtn_systm 	
		   where 
	       		  pm_idn(+)=ps_idn and 
	       		  replace(ps_nm,' ','')='$name2search_ns' and 
	       		  pm_prmtn_cdr_id in ('DB11','DB15','DB16','DB14')";
$statemen=oci_parse($conn,$prequery);
oci_execute($statemen);
if ($row = oci_fetch_array($statemen))
	$pd=$row['PD'];


echo "<table id='stab'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Section</th>";
echo "<th>From</th>";
echo "<th>To</th>";
echo "</tr>";
$query="select 
				a.ps_nm,
				to_char(a.ps_frm_dt,'dd/mm/yyyy') ps_frm_dt,
				a.ps_to_dt,
				nvl(a.sctn,sctn.dmn_dscrptn) sctn,

				(nvl(a.ps_to_dt,decode(a.ps_frm_dt,maxd,sysdate,a.ps_frm_dt)) -greatest(ps_frm_dt,to_date('$pd','dd/mm/yyyy'))) dayz,
				case 		
						when nvl(sctn.dmn_shrt_nm,'fl')='fl' and a.sctn is null then 'fl'
						when nvl(sctn.dmn_shrt_nm,'fl')<>'fl' then 'hq'
						when lower(nvl(a.sctn,'niet')) like '%part%' then 'fl'
						when lower(nvl(a.sctn,'niet')) not like '%part%' and a.sctn is not null then 'hq'
				end hfl,
				case 
						when  nvl(ps_to_dt,sysdate)>=to_date('$pd','dd/mm/yyyy') then 'y'
						else 'n' 
				end     aao
		from 
				sctn_hstry_dummy a,
				(select ps_idn mxid,max(ps_frm_dt) maxd from sctn_hstry_dummy group by ps_idn) mx,
				prsnl_infrmtn_systm b,
				estt_dmn_mstr sctn 
		where replace(a.ps_nm,' ','') ='$name2search_ns' and a.ps_idn=b.ps_idn and sctn.dmn_id(+)=a.ps_sctn_id and mxid=b.ps_idn
		and   a.ps_frm_dt is not null
		order by a.ps_frm_dt";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$results=array();
$num = oci_fetch_all($statemen, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
oci_execute($statemen);
$f_days=0;
$hq_days=0;
$cntz=0;
while ($row = oci_fetch_array($statemen))
				{
$cntz+=1;

$nm=$row["PS_NM"];
$sctn=$row["SCTN"];
$from=$row["PS_FRM_DT"];
$to=$row["PS_TO_DT"];
$tdayz=$row["DAYZ"];
$hfl=$row["HFL"];
$aao=$row['AAO'];
/*
if (($cntz==$num) and ($to=='')) 
	{
$time = strtotime($from);
$ft = date('d-m-Y',$time);
$tdayz=getdate('d-m-Y')-$ft;
	}
*/
if ($aao=='y'){
if ($hfl=='fl') $f_days+=$tdayz;
else            $hq_days+=$tdayz;
			  }

echo "<tr>";
echo "<td>$nm</td>";
echo "<td>$sctn</td>";
echo "<td>$from</td>";
echo "<td>$to</td>";
echo "</tr>";
				}
echo "</table>";
echo "<div style='font-weight:bold;text-align:center;width:100%;font-size:22px;color:#3333cc;'> Field/HQ posting details after becoming AAO</div>";
echo "<br>";
echo "<div id='b2'>"."$nm served ".eluc($f_days)." in field<div>";
echo "<br>";
echo "<div id='b2'>"."$nm served ".eluc($hq_days)." in HQ<div>";
			}



?>


</body>