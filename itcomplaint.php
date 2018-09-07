<?php
		require_once("./include/membersite_config.php");
		if(!$fgmembersite->CheckLogin())
			{
    		$fgmembersite->RedirectToURL("login.php");
    		exit;
			}
		$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
  		if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}
	    $current_user=$fgmembersite->Userid();
		$usertype=$fgmembersite->Userrole();

        function test_input($data) 
						{
						$data = trim($data);
						$data = stripslashes($data);
						$data = htmlspecialchars($data);
						$data = htmlentities($data);
						return $data;
						}
		function get_date($tds)
						{
						$monthh = array("01"=>"JAN", "02"=>"FEB", "03"=>"MAR",
    	          		"04"=>"APR","05"=>"MAY","06"=>"JUN",
    	          		"07"=>"JUL","08"=>"AUG",
    	          		"09"=>"SEP","10"=>"OCT","11"=>"NOV",
    	          		"12"=>"DEC");
						$tds_split=explode('/',$tds);
    					$tds1=$tds_split[0].'-'.$monthh[$tds_split[1]].'-'.$tds_split[2];
    					return $tds1;

						}
		function getid($nm,$conn)
	    				{       
          					if (!$conn)
							{
							echo 'Failed to connect to Oracle';
	     					die("Connection failed: " . $conn->connect_error);
							}
			      		$query="select ps_idn from prsnl_infrmtn_systm where ps_nm like '$nm' ";
	      				$statemen=oci_parse($conn,$query);
	      				oci_execute($statemen);
	      				if ( $row=oci_fetch_array($statemen)) 
	      						return $row["PS_IDN"];
	 	  				return $nm;
	    				}
	    function getlastind($conn)
	    				{       
          					if (!$conn)
							{
							echo 'Failed to connect to Oracle';
	     					die("Connection failed: " . $conn->connect_error);
							}
						$nm=0;
			      		$query="select nvl(max(slno),0) n from itcomplaints";
	      				$statemen=oci_parse($conn,$query);
	      				oci_execute($statemen);
	      				if ( $row=oci_fetch_array($statemen)) 
	      						return $row["N"];
	 	  				return $nm;
	    				}

?>

<head>

<style>
table 
              {
                width: 100%; 
                background-color: #f1f1c1;
              }
              th
              {
              text-align: left;
              }
              table  tr:nth-child(even) 
              {
                background-color: #eee;
              }
              table tr:nth-child(odd) 
              {
                background-color: #fff;
              }
              table th 
              {
                color: white;
                background-color: black;
              }
              #hea2
              {
              text-align: center;
              float:left;
              width:100%;
              font-weight: bold;
              background-color:#eee; 
              }
              .midg
				{
				float:left;
				width:25%;
				}
              .llg
				{
				float:left;
				width:70%;
				}
			 .novis
				{
				 visibility: hidden;
				 width:2px;
			    }
			  #ack
				{
				color:green;
				font-size: 1em;
				text-align: center;

				}

</style>

<script>
	function countdsays()
	 				{
	 				var fd=document.getElementById("fd").value;
	 				var td=document.getElementById("td").value;
	 				fd=stringToDate(fd);
	 				td=stringToDate(td);
	 				//console.log(dbwenn(fds,tds));
	 		 		document.getElementById("days").value=dbwenn(fd,td);
	 		
	 				}	
	 function hidee()
	     			{
	     			document.getElementById("ack").style.visibility="hidden";
	     			document.getElementById("ack").style.position="absolute";
	        		document.getElementById("ack").style.float="left";
	     			}
</script>

</head>



<body>
<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('comp',$_POST)))
	{


//$_SESSION["thdef"]='y';  //required to keep this tab alive on reload


$complaint=test_input($_POST["comp"]);

if ($complaint=="")
		{
	//echo "<warn>DATES CANT BE EMPTY</warn>";
	echo "<button type='button' id='ack' onclick='hidee()'>Please enter dates, click to hide</button>";
	//die("DATES CANT BE EMPTY");
		}
		else
		{
$docomp=get_date(date("d/m/Y"));
$comp=test_input($_POST["comp"]);
$cloc=test_input($_POST["cloc"]);
			

$idleave=getid($current_user,$conn);
$decis='n';
$slno=getlastind($conn)+1;
$query="insert into itcomplaints (slno,idno,complaint,dated,stat,cloc) 
        values (:slno,:idno,:complaint,:dated,:stat,:cloc) ";
$statemen=oci_parse($conn,$query);


oci_bind_by_name($statemen, ':idno', $idleave);
oci_bind_by_name($statemen, ':dated', $docomp);
oci_bind_by_name($statemen, ':complaint', $comp);
oci_bind_by_name($statemen, ':stat', $decis);
oci_bind_by_name($statemen, ':slno', $slno);
oci_bind_by_name($statemen, ':cloc', $cloc);

oci_execute($statemen);
			
echo "<button type='button' id='ack' onclick='hidee()'>Your complaint is logged, click to hide</button>";			
      }
	}
?>

<b2 id="hea2">Pending Complaints</b2>
<table id="t01">
<tr>
<th><b1 class="bl"> Name</b1></th>
<th><b1 class="bl"> Complaint</b1></th>
<th><b1 class="bl"> Location</b1></th>
<th><b1 class="bl"> Date</b1></th>
<th><b1 class="bl"> Addressed?</b1></th>
<th><b1 class="bl"> Remarks</b1></th>

</tr>

<?php
$idleave2=getid($current_user,$conn);
$query="select idno,ps_nm,complaint,cloc,dated,stat,remarks 
		from 
		itcomplaints,prsnl_infrmtn_systm 
        where ps_idn=idno and ps_idn='$idleave2'";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$count=0;
while( $row=oci_fetch_array($statemen))
		{
$idnoc=$row["IDNO"];
$nmc=$row["PS_NM"];
$cloc=$row["CLOC"];
$comp=$row["COMPLAINT"];
$docomp=$row["DATED"];
$apc=$row["STAT"];
$remarks=$row["REMARKS"];
$chcn="checked";
$chcy="";
if($apc=='y') 
	{
	$chcy="checked";
	$chcn="";
	}

echo "<tr>";



echo "<td><inp id='nmc$count' name='nmc$count'> $nmc</inp>";
echo "<input id='nmcinp$count' name='nmcinp$count' type='text' class='novis' value='$nmc'></td>";

echo "<td><inp id='comp$count' name='comp$count'> $comp</inp>";
echo "<input id='compinp$count' name='compinp$count' type='text' class='novis' value='$comp'></td>";

echo "<td><inp id='cloc$count' name='cloc$count'> $cloc</inp>";
echo "<input id='clocinp$count' name='clocinp$count' type='text' class='novis' value='$cloc'></td>";

echo "<td><inp id='docomp$count' name='docomp$count'> $docomp</inp>";
echo "<input id='docompinp$count' name='docompinp$count' type='text' class='novis' value='$docomp'></td>";

echo "<td>yes<input type='radio' id='apcy$count' name='apcy$count' value='y' $chcy>";
echo "no<input type='radio' id='apcn$count' name='apcy$count' value='n' $chcn></td>";

echo "<td><inp id='remarks$count' name='remarks$count'> $remarks</inp>";
echo "<input id='remarksinp$count' name='remarksinp$count' type='text' class='novis' value='$remarks'></td>";
echo "</tr>";
$count+=1;
		}
?>
</table>



<b4 id="hea2">New Complaint</b4>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset>
	<legend>Enter details</legend>

	<lab class="midg bl">Describe Complaint</lab>
	<inp class="llg">
	:<input type="text" id="comp" name="comp"  size="80"
	   value='<?php echo $fgmembersite->SafeDisplay('comp') ?>'
	  >
	 </inp>

	 <lab class="midg bl">Where?</lab>
	<inp class="llg">
	:<input type="text" id="cloc" name="cloc"  size="80"
	   value='<?php echo $fgmembersite->SafeDisplay('cloc') ?>'
	  >
	 </inp>
	
</fieldset>
<input type="submit" name="subut3" id="subut3" value="Log" >
</form>

</body>