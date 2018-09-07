<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>

<?php
   //require_once("./displayHelper.php");
   //require_once("./include/membersite_config.php");
    $query="not received";
    $order_by_param="not received";
    if (!isset($_SESSION['toggle'])) $_SESSION['toggle']='desc';
    if ($_SESSION['toggle']!='desc') $_SESSION['toggle']='desc';
	else $_SESSION['toggle']='';

    if (isset($_REQUEST["q"])) 
    	{
    		$order_by_param="nvl(".$_REQUEST["q"].",'01/01/1800')";
    		if (preg_match('/[0-9]\/[0-9]*/', $_REQUEST["q"]))  $order_by_param=$_REQUEST["q"];
        }
    if (isset($_REQUEST["t"])) $query=$_REQUEST["t"];
    $query=str_replace(',,', '+', $query);
    //$query=str_replace(',,,', 'null', $query);
	$query=$query."  order by ".$order_by_param." ".$_SESSION['toggle'];
	
	$respo="";
	
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
	$respo.=  "
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
	    
	  // $respo=$order_by_param;
	echo $respo;
	 
	 
			
?>