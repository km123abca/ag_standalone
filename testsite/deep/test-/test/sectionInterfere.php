<?php
   
	
	
	$wing=$_REQUEST["q"];
	$respo="";	
	
	$query="select dmn_id,dmn_dscrptn from estt_dmn_mstr where dmn_id_rltn ='".$wing."'";
	//echo $query;
	$conn=oci_connect("ags","ags","localhost/xe");
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
	//echo $branch;
   
	$respo = $respo.'<option value=\''.$branchcode.'\'>'.$branch.'</option>';
	
	
	    }
	$textTobedisplayed='hellfire';
	//echo '<option value=\''.$branch.'\'>'.$branch.'</option>';
	echo $respo;
	 
	 
			
?>