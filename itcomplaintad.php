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
function hidee()
	     			{
	     			document.getElementById("ack").style.visibility="hidden";
	     			document.getElementById("ack").style.position="absolute";
	        		document.getElementById("ack").style.float="left";
	     			}
</script>


 </head>

 <body>

 <hea id="hea2">Address and Solve IT complaints</hea>

<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('apyca0',$_POST)))
		{echo "<button type='button' id='ack' onclick='hidee()'>approvals/denials confirmed, 
	           click here to hide notification</button>";
	    // $_SESSION["secdef"]='y';//session variable to keep this tab alive when the page reloads
		$cn=0;
		while(array_key_exists("apyca$cn",$_POST))
			{
		
		$pid=getid($_POST["nminpca$cn"],$conn);
		$comp=$_POST["compcainp$cn"];
		$datecomp=$_POST["datecompinp$cn"];
		$papy=$_POST["apyca$cn"];
		$remarks1=$_POST["remarkscainp$cn"];
		$slnoca=$_POST["slinpca$cn"];

		
        //check if already approved
        $query="select stat,remarks from itcomplaints where 
		        idno='$pid' and
		        dated='$datecomp' and slno=$slnoca";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);
		$prevaprove='none';
		$prerem='none';
		while( $row=oci_fetch_array($statemen))
		{
         $prevaprove=$row["STAT"];
         $prerem=$row["REMARKS"];
		}
       
         //only if there are changes in approval
        if (!(($prevaprove==$papy)&&($prerem==$remarks1)))
        {//echo 'in here';
		$query="update itcomplaints set  stat='$papy',remarks='$remarks1'
		        where 
		        idno='$pid' and
		        dated='$datecomp' and slno=$slnoca";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);

        }

        $cn+=1;
			}

		}

?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
      onsubmit="return confirm('Are you sure you want to submit this form?');">
<table id="t01">
<tr>
<th><b1 class="bl"> Complaint No</b1></th>
<th><b1 class="bl"> Name</b1></th>
<th><b1 class="bl"> Complaint</b1></th>
<th><b1 class="bl"> Where?</b1></th>
<th><b1 class="bl"> Date</b1></th>
<th><b1 class="bl"> Addressed?</b1></th>
<th><b1 class="bl"> Remarks</b1></th>
</tr>

<?php

$query="select slno,idno,ps_nm,complaint,dated,stat,remarks,cloc 
		from 
		itcomplaints,prsnl_infrmtn_systm 
        where ps_idn=idno ";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$count=0;
while( $row=oci_fetch_array($statemen))
		{
$slno=$row["SLNO"];
$idno=$row["IDNO"];
$nm=$row["PS_NM"];
$comp=$row["COMPLAINT"];
$datecomp=$row["DATED"];
$apca=$row["STAT"];
$remarks1=$row["REMARKS"];
$cloc1=$row["CLOC"];

$chn="checked";
$chy="";
if($apca=='y') 
	{
	$chy="checked";
	$chn="";
	}

echo "<tr>";

echo "<td><inp id='slca$count' name='slca$count'> $slno</inp>";
echo "<input id='slinpca$count' name='slinpca$count' class='novis' type='text' value='$slno'></td>";

echo "<td><inp id='nmca$count' name='nmca$count'> $nm</inp>";
echo "<input id='nminpca$count' name='nminpca$count' type='text' class='novis' value='$nm'></td>";

echo "<td><inp id='compca$count' name='compca$count'> $comp</inp>";
echo "<input id='compcainp$count' name='compcainp$count' type='text' class='novis' value='$comp'></td>";

echo "<td><inp id='cloc1$count' name='cloc1$count'> $cloc1</inp>";
echo "<input id='cloc1inp$count' name='cloc1inp$count' type='text' class='novis' value='$cloc1'></td>";

echo "<td><inp id='datecomp$count' name='datecomp$count'> $datecomp</inp>";
echo "<input id='datecompinp$count' name='datecompinp$count' type='text' class='novis' value='$datecomp'></td>";

echo "<td>yes<input type='radio' id='apyca$count' name='apyca$count' value='y' $chy>";
echo "no<input type='radio' id='apnca$count' name='apyca$count' value='n' $chn></td>";

//echo "<td><inp id='remarksca$count' name='remarksca$count'> $remarks1</inp>";
echo "<td><input id='remarkscainp$count' name='remarkscainp$count' type='text'  
           style='width:100%;' value='$remarks1'></td>";
echo "</tr>";
$count+=1;
		}
?>
</table>


<input type="submit" name="subut5" id="subut5" value="confirm approval/denial" >
</form>
<ul>

<li id="leaveerror"><warn>*Addressed?</warn></li>
</ul>
</body>



