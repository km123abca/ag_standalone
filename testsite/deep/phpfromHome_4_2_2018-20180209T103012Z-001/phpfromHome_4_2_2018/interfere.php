<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>



<?php


   //*********************
   //function to preserve selection
   function getsel($str,$dest)
    	{
    	$disp='';
    	
             
    	if (isset($_POST['$dest']))
    	   {
    	   	$disp=($str==($_POST['$dest']))?'selected':'';
    	   }
    	//if ($str=='DC05')
        //$disp='selected';
    	return $disp;
    	}
    
	//new code added to preserve selection
	$dest="nil";
	if (isset($_REQUEST["dest"])) $dest=$_REQUEST["dest"];
	//******************************


	$wing=$_REQUEST["q"];
	$dmntyp=$_REQUEST["n"];
	
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
    //if ($branchcode!='DC05') continue;
  
    //************************
    //new code added to preserve selection
	$sel='';
	if ($dest!="nil")
		{
		$sel=getsel($branchcode,$dest);
		}
	//************************

	//$respo = $respo.'<option value=\''.$branchcode.'\'  \'$sel\''>'.$branch.'</option>';
		$respo = $respo."<option value='$branchcode' $sel>$branch</option>";
	    }
	echo $respo;
	    //if (isset($_POST[$dest]) ) $dest=$_POST[$dest];
	 //echo "<option value='$dest' >$dest</option>";
	 
			
?>