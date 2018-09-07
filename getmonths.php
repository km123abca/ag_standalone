<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}



?>


<?php
$idno='0101';
if (isset($_REQUEST["q"]))  $idno=$_REQUEST["q"];
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
  	if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}

$query="select er_mnth_of_acnt from clms_erng_yrfl,prsnl_infrmtn_systm where er_idn=ps_idn
        and ps_nm='$idno'  ";

$query2=" select er_mnth_of_acnt from clms_erng_entry,prsnl_infrmtn_systm where er_idn=ps_idn
        and ps_nm='$idno'  ";
 $query=$query." union ".$query2." order by er_mnth_of_acnt desc";

  	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	$month="null";
	$resp_tex="<option value='n'>no entry </option>";
	while($row=oci_fetch_array($statemen))
		{
	if ($resp_tex=="<option value='no'>no entry </option>") $resp_tex="";
    $month=$row["ER_MNTH_OF_ACNT"];
    $resp_tex.="<option value='$month'>$month</option>";
		}

	echo $resp_tex;
?>