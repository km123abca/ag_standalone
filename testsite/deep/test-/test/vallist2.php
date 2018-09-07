<?php
require_once("./include/membersite_config.php");
$val='ps_idn';
$opt='no';
$big='n';
if (isset($_REQUEST["big"])) $big='y';
if (isset($_REQUEST["q"])) $val=$_REQUEST["q"];
if (isset($_REQUEST["b"])) $opt=$_REQUEST["b"];
$val=strtoupper($val);
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	 if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
if ($opt=='desc')
$query="select distinct $val id,dmn_dscrptn val  from 
        prsnl_infrmtn_systm,estt_dmn_mstr where dmn_id(+)=$val order by $val ";
 else
 	$query="select distinct $val val,$val id  from 
        prsnl_infrmtn_systm order by $val ";

 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
  $respotext="";
  $respotext="<option value='%'>select all</option>";
 //$respotext="<option value='%'>select all</option>";
 while ($row=oci_fetch_array($statemen))
 	{
 $listitemv=$row["ID"];		
 $listitem=$row["VAL"];
 $respotext.="<option value='$listitemv'>$listitem</option>";
 	//$respotext. ="<option value='$listitem'>$listitem</option>";
 

 //$respotext=$respotext.'<'.'hello';
 //$respotext="<"."option";
 	}
 echo $respotext;
?>