<?php
require_once("./include/membersite_config.php");
$dmnidrltn='%';
$dmntyp='02';
if (isset($_REQUEST["q"])) $dmnidrltn=$_REQUEST["q"];
if (isset($_REQUEST["r"]))  $dmntyp=$_REQUEST["r"];
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	 if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
if ($dmnidrltn!='%')
{
$query="select dmn_id  from estt_dmn_mstr where dmn_dscrptn= replace('$dmnidrltn',' and ',' & ')";
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 if ($row=oci_fetch_array($statemen))
 	{
 	 $dmnidrltn=$row["DMN_ID"];
   	}
}


 $query="select distinct replace(dmn_dscrptn,'&','and') DMN_DSCRPTN  from estt_dmn_mstr where nvl(dmn_id_rltn,'%') like '$dmnidrltn' and dmn_typ like '$dmntyp' order by replace(dmn_dscrptn,'&','and')";
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 $respotext="";
 //$respotext="<option value='%'>select all</option>";
 while ($row=oci_fetch_array($statemen))
 	{
 		
 $wing=$row["DMN_DSCRPTN"];
 $respotext.="<option value='$wing'>";
 //$respotext=$respotext.'<'.'hello';
 //$respotext="<"."option";
 	}
 echo $respotext;
?>