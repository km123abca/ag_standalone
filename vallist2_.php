
<?php
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











require_once("./include/membersite_config.php");
$val='ps_idn';
$opt='no';
$big='n';
$respotext="";
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
$defval='none';
if(isset($_REQUEST["defval"])) $defval=($_REQUEST["defval"]);
$defval=($defval=='')?'none':$defval;
	if (!($defval=='none'))
		{
		$descdefval=descr($defval,$conn);
		$respotext=$respotext."<option value='$defval'>$descdefval</option>";
		}



if ($opt=='desc')
$query="select distinct $val id,dmn_dscrptn val  from 
        prsnl_infrmtn_systm,estt_dmn_mstr where dmn_id(+)=$val order by $val ";
 else
 	$query="select distinct $val val,$val id  from 
        prsnl_infrmtn_systm order by $val ";

 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
  
  $respotext=$respotext."<option value='%'>select all</option>";
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