<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>

<?php
   
	
	
	$wing=$_REQUEST["q"];
	$dmntyp=$_REQUEST["n"];
	$dest='x';
	if(isset($_REQUEST["dest"])) $dest=($_REQUEST["dest"]);
	echo "<script>";
	echo "console.log('".$fgmembersite->SafeDisplay('wing')."');";
	echo "</script>";
	$respo="<option value='%'>select all</option>";	
	$query="select dmn_id,dmn_dscrptn from estt_dmn_mstr where nvl(dmn_id_rltn,'0') like '".$wing."' and dmn_typ like '$dmntyp' and dmn_shrt_nm not in ('KTKM','KDDE') order by dmn_dscrptn";
	//$conn=oci_connect("km","rt","localhost/test2");
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
	$branch=$row["DMN_DSCRPTN"];
	$branchcode=$row["DMN_ID"];
	$selchoice='';
	$selchoice=($fgmembersite->SafeDisplay($dest)==$branchcode)?'selected':'';
	echo $branch." ".$selchoice."<br>";
	$respo = $respo.'<option value=\''.$branchcode.'\' '.$selchoice.'>'.$branch.'</option>';
	    }
	//echo $respo;
	 
	 
			
?>