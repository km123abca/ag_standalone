<?php
require_once("./include/membersite_config.php");
$val='ps_idn';
$opt='no';
$big='n';
if (isset($_REQUEST["big"])) $big='y';
if (isset($_REQUEST["q"])) $val=$_REQUEST["q"];
if (isset($_REQUEST["b"])) $opt=$_REQUEST["b"];
$tabb='niet';
if (isset($_REQUEST["tabo"])) $tabb=$_REQUEST["tabo"];
$val=strtoupper($val);
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	 if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
if ($opt=='desc')
$query="select distinct $val,dmn_dscrptn val  from 
        prsnl_infrmtn_systm,estt_dmn_mstr where dmn_id(+)=$val order by $val ";
 else
 	$query="select distinct $val val  from 
        prsnl_infrmtn_systm order by $val ";

 if (($tabb!='niet'))
 	{
 	$query="select distinct ps_nm val from (select  ps_nm  
            from ";
    $query.=$tabb; 
    $query.=",prsnl_infrmtn_systm where ps_idn=$val) a order by ps_nm ";
   // $query="select distinct ps_nm val  from 
   //    prsnl_infrmtn_systm order by ps_nm ";
	}


 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
  $respotext="";
  //if ($big=='y') $respotext="<option value='%'>select all</option>";
 //$respotext="<option value='%'>select all</option>";
 while ($row=oci_fetch_array($statemen))
 	{
 		
 $listitem=$row["VAL"];
// if ($big=='y')
 	//$respotext. ="<option value='$listitem'>".$listitem.'</option>';
 //else
 	$respotext.="<option value='$listitem'>";

 //$respotext=$respotext.'<'.'hello';
 //$respotext="<"."option";
 	}
 echo $respotext;
?>