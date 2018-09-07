<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}


function descr($dmnid,$conn)
	    { 
	    	//require_once("./include/membersite_config.php");
           //$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	      $dmnid=strtoupper($dmnid); 
          if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
	      $query="select dmn_dscrptn from estt_dmn_mstr where 
	              dmn_id like"." '$dmnid'";
	// echo $query;echo '<br>';
	// $query="select dmn_id from estt_dmn_mstr where lower(dmn_dscrptn) like 'economic & revenue sector audit'";
	// echo $query;	;echo '<br>';
	              //return "shalo";
	      $statemen=oci_parse($conn,$query);
	      oci_execute($statemen);
	      if ( $row=oci_fetch_array($statemen))
	 	    {   //echo $row["DMN_ID"];
	 		return $row["DMN_DSCRPTN"];
	        }
	    //echo 'none found';
	      return 'Not Given';
	    }

?>

<?php
   $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	if (!$conn)
		{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
		}
	
	$respo="";
	$wing=$_REQUEST["q"];
	$dmntyp=$_REQUEST["n"];
	$dest='x';
	$defval='none';
	//$defval=($defval=='')?'none':$defval;
	if(isset($_REQUEST["dest"])) $dest=($_REQUEST["dest"]);
	if(isset($_REQUEST["defval"])) $defval=($_REQUEST["defval"]);
	$defval=($defval=='')?'none':$defval;
	if (!($defval=='none'))
		{
		$descdefval=descr($defval,$conn);
		$respo=$respo."<option value='$defval'>$descdefval</option>";
		}
	//echo "<script>";
	//echo "console.log('".$dest."');";
	//echo "</script>";
	$respo=$respo."<option value='%'>select all</option>";	
	$query="select dmn_id,dmn_dscrptn from estt_dmn_mstr where nvl(dmn_id_rltn,'0') like '".$wing."' and dmn_typ like '$dmntyp' and dmn_shrt_nm not in ('KTKM','KDDE') order by dmn_dscrptn";
	//$conn=oci_connect("km","rt","localhost/test2");
	
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while($row=oci_fetch_array($statemen))
		{
	$branch=$row["DMN_DSCRPTN"];
	$branchcode=$row["DMN_ID"];
	$selchoice='';
	//$selchoice=($fgmembersite->SafeDisplay($dest)==$branchcode)?'selected':'';

	$respo = $respo.'<option value=\''.$branchcode.'\' '.$selchoice.'>'.$branch.'</option>';
	    }
	echo $respo;
	 
	 
			
?>