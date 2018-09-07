<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
	{
    $fgmembersite->RedirectToURL("login.php");
    exit;
	}

$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	if (!$conn)
	{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
	}
?>



<head>
 <h1 id="offheading">  Office of the Accountant General, Thiruvananthapuram</h1>
<style>
							#offheading
							{
							font-size:200%;
							background-color:yellow;
							text-align:center;
							}
							.lg
							{
							float:left;
							/*border:2px solid black;*/
							width:50%;
							}
							.flg
							{
							float:left;
							/*border:2px solid black;*/
							width:100%;
							}
							.inv
							{
							visibility: hidden;
							}
							.floatlef
							{
							float:left;
							clear:both;
							}

							table#t01 
							{
    						width: 80%; 
    						background-color: #f1f1c1;
							}
							th
							{
							text-align: left;
							}
							table#t01 tr:nth-child(even) 
							{
    						background-color: #eee;
							}
							table#t01 tr:nth-child(odd) 
							{
    						background-color: #fff;
							}
							table#t01 th 
							{
    						color: white;
    						background-color: black;
							}
							#lifeline
							{
							visibility: hidden;
							float:right;
							}
							legend
							{
							font-weight: bold;
							}
							#form1
							{
								margin-left: 25%;
							}
							select
							{
								width:96%;
							}
</style>
<script>
			function makeviz(str)
				{
				
				document.getElementById("cdr").style.visibility="hidden";

				if (str=='ps_cdr_id')
				document.getElementById("cdr").style.visibility="visible";	
				
						
				}

			function wingchanged(str)
				{
				if (str!='%')
				{
				document.getElementById("cntt1").disabled=true;
				document.getElementById("wingsel").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("wingsel").checked=false;
				}
				else
				{
			    document.getElementById("cntt1").disabled=false;
				document.getElementById("wingsel").disabled=false;	
				}
				if (str.length!=0)
				{
		    	var xmlhttp = new XMLHttpRequest();
		    	xmlhttp.onreadystatechange = function()
				{
		    	if (this.readyState == 4 && this.status == 200)
					{    //console.log('The resposeText received is this '+this.responseText);
				document.getElementById("branch").innerHTML=this.responseText;
					}
				};
				
				xmlhttp.open("GET", "interfere.php?q=" + str+'&n=03', true);
				//console.log(str);
        		xmlhttp.send();
				}
			 	}
	
			function branchchanged(str)
			 	{
				//document.getElementById("wing").value=document.getElementById("wing1").value;
				if (str!='%')
				{
                document.getElementById("cntt1").disabled=true;
				document.getElementById("wingsel").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("wingsel").checked=false;

				document.getElementById("cntt2").disabled=true;
				document.getElementById("branchsel").disabled=true;
				document.getElementById("cntt2").checked=false;
				document.getElementById("branchsel").checked=false;
				}
				else
				{
			    document.getElementById("cntt2").disabled=false;
				document.getElementById("branchsel").disabled=false;	

				document.getElementById("cntt1").disabled=false;
				document.getElementById("wingsel").disabled=false;
				}
		 		if (str.length!=0)
				{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function()
					{
			 	if (this.readyState == 4 && this.status == 200)
						{   // console.log('The resposeText received is this '+this.responseText);
		     	document.getElementById("section").innerHTML=this.responseText;
						}
				    };
			 	xmlhttp.open("GET", "interfere.php?q=" + str+'&n=%', true);
				//console.log(str);
        		xmlhttp.send();
				}
				}

				function disablehq(str)
				{
				if (str!='%')
				{
                document.getElementById("cntt5").disabled=true;
				document.getElementById("roomsel").disabled=true;
				document.getElementById("cntt5").checked=false;
				document.getElementById("roomsel").checked=false;
			
				}
				else
				{
			    document.getElementById("cntt5").disabled=false;
				document.getElementById("roomsel").disabled=false;	
				}	
				}

				function secchanged(str)
				{
				if (str!='%')
				{
                document.getElementById("cntt1").disabled=true;
				document.getElementById("wingsel").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("wingsel").checked=false;

				document.getElementById("cntt2").disabled=true;
				document.getElementById("branchsel").disabled=true;
				document.getElementById("cntt2").checked=false;
				document.getElementById("branchsel").checked=false;

				document.getElementById("cntt3").disabled=true;
				document.getElementById("secsel").disabled=true;
				document.getElementById("cntt3").checked=false;
				document.getElementById("secsel").checked=false;
			
				}
				else
				{
			    document.getElementById("cntt3").disabled=false;
				document.getElementById("secsel").disabled=false;	

				document.getElementById("cntt2").disabled=false;
				document.getElementById("branchsel").disabled=false;

				document.getElementById("cntt1").disabled=false;
				document.getElementById("wingsel").disabled=false;	
				}	
				}


				function cdrchanged(str)
				{
				if (str!='%')
				{
                document.getElementById("cntt1").disabled=true;
				document.getElementById("wingsel").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("wingsel").checked=false;

				document.getElementById("cntt2").disabled=true;
				document.getElementById("branchsel").disabled=true;
				document.getElementById("cntt2").checked=false;
				document.getElementById("branchsel").checked=false;

				document.getElementById("cntt3").disabled=true;
				document.getElementById("secsel").disabled=true;
				document.getElementById("cntt3").checked=false;
				document.getElementById("secsel").checked=false;

				document.getElementById("cntt4").disabled=true;
				document.getElementById("cadsel").disabled=true;
				document.getElementById("cntt4").checked=false;
				document.getElementById("cadsel").checked=false;
			
				}
				else
				{
			    document.getElementById("cntt3").disabled=false;
				document.getElementById("secsel").disabled=false;	

				document.getElementById("cntt2").disabled=false;
				document.getElementById("branchsel").disabled=false;

				document.getElementById("cntt1").disabled=false;
				document.getElementById("wingsel").disabled=false;	

				document.getElementById("cntt4").disabled=false;
				document.getElementById("cadsel").disabled=false;	
				}	
				}

				function wingbutton(str)
				  {
				var x=document.getElementById("wingsel").value;
				if (x=="ps_wing")
                     {
                document.getElementById("cntt1").disabled=true;
				document.getElementById("cntt1").checked=false;
                     }

				  }

				function branchbutton(str)
				  {
				var x=document.getElementById("branchsel").value;
				if (x=="ps_brnch_id")
                     {
                document.getElementById("cntt1").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("cntt2").disabled=true;
				document.getElementById("cntt2").checked=false;
                     }

				  }

				function secbutton(str)
				  {
				var x=document.getElementById("secsel").value;
				if (x=="ps_sctn_id")
                     {
                document.getElementById("cntt1").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("cntt2").disabled=true;
				document.getElementById("cntt2").checked=false;
				document.getElementById("cntt3").disabled=true;
				document.getElementById("cntt3").checked=false;
                     }

				  }

			    function cdrbutton(str)
				  {
				var x=document.getElementById("cadsel").value;
				if (x=="ps_cdr_id")
                     {
                document.getElementById("cntt1").disabled=true;
				document.getElementById("cntt1").checked=false;
				document.getElementById("cntt2").disabled=true;
				document.getElementById("cntt2").checked=false;
				document.getElementById("cntt3").disabled=true;
				document.getElementById("cntt3").checked=false;
				document.getElementById("cntt4").disabled=true;
				document.getElementById("cntt4").checked=false;
                     }

				  }

				function roombutton(str)
				  {
				var x=document.getElementById("roomsel").value;
				if (x=="ps_room_no")
                     {
                document.getElementById("cntt5").disabled=true;
				document.getElementById("cntt5").checked=false;
                     }

				  }

				  function makeinviz()
				  {
				  	document.getElementById("form1").style.visibility="hidden";
				  	document.getElementById("form1").style.position="absolute";
				  	document.getElementById("form1").style.float="left";
				  	document.getElementById("lifeline").style.visibility="visible";
				  	
				  }
</script>
</head>


<body>
<form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset class="lg">
	<legend>Select specifics</legend>

	<lab class="lg bl">Wing</lab>   
	      <inp class="lg">
	      :<select id="wing" name="wing"  onchange="wingchanged(this.value)"  >  
          <option value='%' selected>select all</option>
	      <option value='W01'>GSSA</option>
	      <option value='W11'>ERSA</option>
	      <option value='W21'>PD Central</option>
	      </select>
	      </inp>

	<lab class="lg bl">Branch</lab>   
	      <inp class="lg">
	      :<select id="branch" name="branch" onchange="branchchanged(this.value)"  >  
	      <option value='%' selected>select all</option>
          		<?php
          		$query="select dmn_id, dmn_dscrptn from estt_dmn_mstr where dmn_typ='03'";
          		$statemen=oci_parse($conn,$query);
		  		oci_execute($statemen);
	      		while( $row=oci_fetch_array($statemen))
	      				{
	      		$val=$row["DMN_ID"];
	      		$dumval=$row["DMN_DSCRPTN"];
	      		echo "<option value='$val'>$dumval</option>";
	      				}
          		?>
	      </select>
	      </inp>

	<lab class="lg bl">Section</lab>   
	      <inp class="lg">
	      :<select id="section" name="section" onchange="secchanged(this.value)"  >  
	      <option value='%' selected>select all</option>
          		<?php
          		$query="select dmn_id, dmn_dscrptn from estt_dmn_mstr where dmn_typ='17'";
          		$statemen=oci_parse($conn,$query);
		  		oci_execute($statemen);
	      		while( $row=oci_fetch_array($statemen))
	      				{
	      		$val=$row["DMN_ID"];
	      		$dumval=$row["DMN_DSCRPTN"];
	      		echo "<option value='$val'>$dumval</option>";
	      				}
          		?>
	      </select>
	      </inp>

	 <lab class="lg bl">Designation</lab>   
	      <inp class="lg">
	      :<select id="cadre" name="cadre" onchange="cdrchanged(this.value)"  >   
	      <option value='%' selected>select all</option>
          		<?php
          		$query="select dmn_id, dmn_dscrptn from estt_dmn_mstr where dmn_typ='01'";
          		$statemen=oci_parse($conn,$query);
		  		oci_execute($statemen);
	      		while( $row=oci_fetch_array($statemen))
	      				{
	      		$val=$row["DMN_ID"];
	      		$dumval=$row["DMN_DSCRPTN"];
	      		echo "<option value='$val'>$dumval</option>";
	      				}
          		?>
	      </select>
	      </inp>

	 <lab class="lg bl">HQ</lab>   
	      <inp class="lg">
	      :<select id="room" name="room"  onchange="disablehq(this.value)"  >  
          <option value='%' selected>select all</option>
	      <option value='TVM'>TVM</option>
	      <option value='EKM'>Cochin</option>
	      <option value='TCR'>Trichur</option>
	      <option value='KDE'>Kozhikode</option>
	      <option value='KTM'>Kottayam</option>
	      </select>
	      </inp>


</fieldset>



<fieldset class="lg">
	<legend>Count to be shown </legend>
	<lab class="flg"><input  type='radio' id='wingsel' name='sel' value='ps_wing' onfocus="wingbutton()"
	                                                                              checked>per wing</lab>
	<lab class="flg"><input  type='radio' id='branchsel' name='sel' value='ps_brnch_id' onfocus="branchbutton()">per branch</lab>
	<lab class="flg"><input  type='radio' id='secsel' name='sel' value='ps_sctn_id' onfocus='secbutton()'>per section</lab>
	<lab class="flg"><input  type='radio' id='cadsel' name='sel' value='ps_cdr_id' onfocus="cdrbutton()">per cadre</lab>
	<lab class="flg"><input  type='radio' id='roomsel' name='sel' value='ps_room_no' onfocus='roombutton()'>per HQ</lab>
</fieldset>



<fieldset class="lg">
	<legend>Select what to be displayed?</legend>
	<lab class="flg"><input  type='radio' id='cntt1' name='csel' value='ps_wing' 
	                 onfocus="makeviz(this.value) " >wing names</lab>
	<lab class="flg"><input  type='radio' id='cntt2' name='csel' value='ps_brnch_id' 
					 onfocus="makeviz(this.value) " checked>branch names</lab>
	<lab class="flg"><input  type='radio' id='cntt3' name='csel' value='ps_sctn_id' 
					 onfocus="makeviz(this.value) ">section names</lab>
	<lab class="flg"><input  type='radio' id='cntt5' name='csel' value='ps_room_no' 
					 onfocus="makeviz(this.value) " >HQs</lab>
	<lab class="flg"><input  type='radio' id='cntt4' name='csel' value='ps_cdr_id' 
	                 onfocus="makeviz(this.value) " >employee names</lab>
    
    <opto id="cdr" class="inv">
	<lab class="lg bl ">Designation</lab>   
	      <inp class="lg">
	      :<select id="cadref" name="cadref">   <!-- onchange="wingchanged(this.value)"  >  -->
	      <option value='%' selected>select all</option>
          		<?php
          		$query="select dmn_id, dmn_dscrptn from estt_dmn_mstr where dmn_typ='01' order by dmn_id";
          		$statemen=oci_parse($conn,$query);
		  		oci_execute($statemen);
	      		while( $row=oci_fetch_array($statemen))
	      				{
	      		$val=$row["DMN_ID"];
	      		$dumval=$row["DMN_DSCRPTN"];
	      		echo "<option value='$val'>$dumval</option>";
	      				}
          		?>
	      </select>
	      </inp>
	</opto>

</fieldset>
<input type="submit" name="generate" id="subut" class="floatlef">
<button type="button" onclick="makeinviz()" class="floatlef">hide</button>
<a href="orarepo_v3.php" class="floatlef">back to reports</a>

</form>
<a href="detailer.php" id="lifeline">Back</a>
<?php
function estt($str,$conn)
  {
  	$query="select dmn_dscrptn from estt_dmn_mstr where dmn_id='$str'";
  	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	$resp="uknown parameter";
	if( $row=oci_fetch_array($statemen))
	   {
	   	$resp=$row["DMN_DSCRPTN"];
	   }
    return $resp;
  }
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing',$_POST)))
	{
//specifics	
$wing=$_POST["wing"];
$branch=$_POST["branch"];
$section=$_POST["section"];
$cadre=$_POST["cadre"];
$hq=$_POST["room"];

$cdrid=$_POST["cadref"];

//per branch per section etc
$per_crt=($_POST["sel"]);

//no of which item?
$tobecnt=isset($_POST["csel"])?($_POST["csel"]):"";
if ($tobecnt=='ps_cdr_id')
     {
     $cadre=$cdrid;
     $desc=($cadre=='%')?'employees':estt($cadre,$conn);
     }
if ($tobecnt=='ps_cdr_id') $tobecnt='ps_nm';
if ($per_crt=='ps_cdr_id') 
	  {
	  	$tobecnt='ps_nm';
	  	$desc='employees';
	  }
$code2desc=array("ps_wing"=>"wings","ps_brnch_id"=>"branches","ps_sctn_id"=>"sections"
	              ,"ps_cdr_id"=>"cadres","ps_room_no"=>"HQs","ps_idn"=>"employees");
if (($tobecnt=="")||($per_crt=="")) die("stopping");

$query="select distinct $per_crt col,$tobecnt col2,dmn_dscrptn
         from prsnl_infrmtn_systm,estt_dmn_mstr 
        where ps_wing like '$wing' and 
              ($per_crt is not null) and ($tobecnt is not null) and ps_flg='W' and
              ps_brnch_id like '$branch' and
              ps_sctn_id like '$section' and
              ps_cdr_id like '$cadre'    and
              ps_room_no like '$hq' and dmn_id(+)=$per_crt 
              order by $per_crt";
//echo "<h1>per $per_crt how many $tobecnt</h1>";
              //echo $query;	
echo "<table class='floatlef' id='t01'>";
echo "<tr>";
     echo "<th>$code2desc[$per_crt]</th>";
     $desc2=($tobecnt=='ps_nm')?$desc:$code2desc[$tobecnt];
     echo "<th>$desc2"."s</th>";
echo "</tr>";

$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$colstore="";
while( $row=oci_fetch_array($statemen))
	      				{
	      		$col1=$row['DMN_DSCRPTN'];
	      		if ($col1!=$colstore)
	      			$colstore=$col1;
	      		else
	      			$col1="";
	      		$col2=$row["COL2"];
	      		$col2=($tobecnt=='ps_nm')?$col2:estt($col2,$conn);
	      		echo "<tr>";
                echo "<td>$col1</td>";
     		    echo "<td>$col2</td>";
				echo "</tr>";
	      				}
	echo '</table>';
	}

?>
</body>