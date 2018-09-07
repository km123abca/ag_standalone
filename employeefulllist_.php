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

	      // UNNECESSARY STUFF ATTEMPTED TO PRESERVE SELECTION
	    ##########################

	    $brstrval=$fgmembersite->SafeDisplay('branch');
		if (!($brstrval==''))
			{
	    $desbran=descr($brstrval,$conn);
		$brstr="<option value=\'$brstrval\'>$desbran</option>";
			}
		else
			$brstr="<option value=\'%\' >selectt all</option>";
		#########################

		########################
		$secstrval=$fgmembersite->SafeDisplay('section');
		if (!($secstrval==''))
			{
	    $descsecstr=descr($secstrval,$conn);
		$secstr="<option value=\'$secstrval\'>$descsecstr</option>";

			}
		else
			$secstr="<option value=\'%\' >selectt all</option>";
		#####################

		################################

		$cdstrval=$fgmembersite->SafeDisplay('cadre');
		if (!($cdstrval==''))
			{
	    $descd=descr($cdstrval,$conn);
		$cdstr="<option value=\'$cdstrval\'>$descd</option>";
			}
		else
			$cdstr="<option value=\'%\' >selectt all</option>";
		########################################
		//echo $brstr."<br>".$secstr."<br>".$cdstr."<br>";
		

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

							select
							{
							width:96%;
							}
							#form1
							{
							margin-left: 25%;
							}

							legend
							{
							font-weight: bold;
							}
							#fs1
							{
							width:50%;
							}
</style>


<script>
function makelistt(rltn,typ,dest,defval='none')
				{
				//console.log(dest+" "+defval);
				if (rltn.length!=0)
					{
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
					document.getElementById(dest).innerHTML=this.responseText;
					//console.log(document.getElementById(dest).innerHTML);
							}
						};
				xmlhttp.open("GET", "interfere.php?q=" + rltn+"&n="+ typ+"&dest="+dest+"&defval="+defval, true);
		    	 xmlhttp.send();
					}
					//console.log(dest+'made');
					//console.log(document.getElementById(dest).innerHTML);
				}
function vallist(col,elem,opto='no',defval='none')
				{
				
				
				
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
					document.getElementById(elem).innerHTML=this.responseText;
					//document.getElementById('branch').innerHTML=<?php  echo "'".$brstr."'";?>+document.getElementById('branch').innerHTML;
					//document.getElementById('section').innerHTML=<?php  echo "'".$secstr."'";?>+document.getElementById('section').innerHTML;
					//document.getElementById('cadre').innerHTML=<?php  echo "'".$cdstr."'";?>+document.getElementById('cadre').innerHTML;
					//console.log(this.responseText);
							}
						};
				if (opto!='desc')
				xmlhttp.open("GET", "vallist2.php?q=" + col, true);
			    else
			    xmlhttp.open("GET", "vallist2.php?q=" + col+"&b="+'desc'+"&big=y"+"&defval="+defval, true);
		    	 xmlhttp.send();
					
				}

	function makeinviz()
				{
				  	document.getElementById("form1").style.visibility="hidden";
				  	document.getElementById("form1").style.position="absolute";
				  	document.getElementById("form1").style.float="left";
				  	document.getElementById("lifeline").style.visibility="visible";
				  	
				}

				
				//makelistt('%','03','branch');
				//makelistt('%','01','cadre');
				//makelistt('%','17','section');
				makelistt('%','03','branch',<?php  echo  "'".$fgmembersite->SafeDisplay('branch')."'";?>);
				makelistt('%','01','cadre',<?php  echo  "'".$fgmembersite->SafeDisplay('cadre')."'";?>);
				makelistt('%','17','section',<?php  echo  "'".$fgmembersite->SafeDisplay('section')."'";?>);
				vallist('sr_sc_st_n','cat','desc',<?php  echo  "'".$fgmembersite->SafeDisplay('cat')."'";?>);
</script>

</head>



<body>

<form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset id="fs1">
	<legend>Filter by</legend>
		<?php  
		//echo $fgmembersite->SafeDisplay('wing');
		$selstrs=array('%'=>'selected','W01'=>'','W11'=>'','W21'=>'');
		$wingsel=$fgmembersite->SafeDisplay('wing');
		$wingsel=($wingsel=='')?'%':$wingsel;
		foreach ($selstrs as $ke=>$va)
			{
			$selstrs[$ke]=(($ke==$wingsel)?'selected':'');
			}
	    
		//$brstr="<option value=\'%\'";

			$roomstrs=array('%'=>'selected','TCR'=>'','TVM'=>'','KTM'=>'','EKM'=>'','KDE'=>'');
		$roomsel=$fgmembersite->SafeDisplay('room');
		$roomsel=($roomsel=='')?'%':$roomsel;
		foreach ($roomstrs as $ke=>$va)
			{
			$roomstrs[$ke]=(($ke==$roomsel)?'selected':'');
			}

		?>
	<lab class="lg bl">Wing</lab>   
	      <inp class="lg">
	      :<select id="wing" name="wing"  onchange="makelistt(this.value,'03','branch')"  >  
          <option value='%'   <?php  echo $selstrs['%'];  ?>   >select all</option>
	      <option value='W01' <?php  echo $selstrs['W01'];?> >GSSA</option>
	      <option value='W11' <?php  echo $selstrs['W11'];?> >ERSA</option>
	      <option value='W21' <?php  echo $selstrs['W21'];?> >PD Central</option>
	      </select>
	      </inp>

	 <lab class="lg bl">Branch</lab>   
	      <inp class="lg">
	      :<select id="branch" name="branch"  onchange="makelistt(this.value,'17','section')" >  
	        <option value='%' >select all</option>
          </select>
	      </inp>

	  <script>
	      //console.log(document.getElementById('branch').innerHTML);
         // document.getElementById('branch').innerHTML=<?php  echo "'".$brstr."'";?>+document.getElementById('branch').innerHTML;
        // console.log(document.getElementById("branch").innerHTML);
          //console.log(<?php  echo "'".$brstr."'";?>);
	  </script>

	      



	  <lab class="lg bl">Section</lab>   
	      <inp class="lg">
	      :<select id="section" name="section"   >  
	      <option value='%' selected>select all</option>
          </select>
	      </inp>

	   <lab class="lg bl">Designation</lab>   
	      <inp class="lg">
	      :<select id="cadre" name="cadre"   >   
	      <option value='%' selected>select all</option>
          		
	      </select>
	      </inp>

	    <lab class="lg bl">HQ</lab>   
	      <inp class="lg">
	      :<select id="room" name="room"    >  
          <option value='%' <?php  echo $roomstrs['%'];  ?> >select all</option>
	      <option value='TVM' <?php  echo $roomstrs['TVM'];  ?> >TVM</option>
	      <option value='EKM' <?php  echo $roomstrs['EKM'];  ?> >Cochin</option>
	      <option value='TCR' <?php  echo $roomstrs['TCR'];  ?> >Trichur</option>
	      <option value='KDE' <?php  echo $roomstrs['KDE'];  ?> >Kozhikode</option>
	      <option value='KTM' <?php  echo $roomstrs['KTM'];  ?> >Kottayam</option>
	      </select>
	      </inp>

	      <lab class="lg bl">Category</lab>   
	      <inp class="lg">
	      :<select id="cat" name="cat"    >  
          
	      </select>
	      </inp>


	
</fieldset>

<fieldset class="lg">
	<legend>What need to be displayed </legend>
	<lab class="flg"><input  type='checkbox' id='w' name='w' value='ps_wing' 
	                         >Wing</lab>
	<lab class="flg"><input  type='checkbox' id='b' name='b' value='ps_brnch_id' >
							 Branch</lab>
	<lab class="flg"><input  type='checkbox' id='s' name='s' value='ps_sctn_id' >
	                         Section</lab>
	<lab class="flg"><input  type='checkbox' id='c' name='c' value='ps_cdr_id'>
	                         Cadre</lab>
	<lab class="flg"><input  type='checkbox' id='r' name='r' value='ps_room_no' >
					         HQ</lab>
	<lab class="flg"><input  type='checkbox' id='ct' name='ct' value='sr_sc_st_n' >
					         Catergory</lab>
	<lab class="flg"><input  type='checkbox' id='nm' name='nm' value='ps_nm' >
					         Employee Names</lab>
</fieldset>
<input type="submit" name="generate" id="subut" class="floatlef">
<button type="button" onclick="makeinviz()" class="floatlef">hide</button>
<a href="index.php" class="floatlef">back to main menu</a>
</form>

<a href="employeefulllist.php" id="lifeline">Back</a>
<?php

if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing',$_POST)))
 {
 	$wing=$_POST["wing"];
	$branch=$_POST["branch"];
	$section=$_POST["section"];
	$cadre=$_POST["cadre"];
	$hq=$_POST["room"];
	$cat=$_POST["cat"];
	//$nm=$_POST["nm"];

	$query="select ";
	$query.=(isset($_POST["w"])?"wng.dmn_dscrptn wing,":"");
	$query.=(isset($_POST["b"])?"brn.dmn_dscrptn branch,":"");
	$query.=(isset($_POST["s"])?"sec.dmn_dscrptn section,":"");
	$query.=(isset($_POST["c"])?"cdr.dmn_dscrptn cadre,":"");
	$query.=(isset($_POST["r"])?"ps_room_no,":"");
	$query.=(isset($_POST["ct"])?"nvl(ct.dmn_dscrptn,'not given') category,":"");
	if (isset($_POST["nm"]))
		{
    $query.="ps_nm tot,";
		}
	else
	    {
    $query.="count(ps_nm) tot,";
	    }
	$query=substr($query,0,strlen($query)-1)." ";
	$query.= "from prsnl_infrmtn_systm,estt_dmn_mstr wng,";
	$query.="estt_dmn_mstr brn,estt_dmn_mstr sec,";
	$query.="estt_dmn_mstr cdr,estt_dmn_mstr ct ";

	$query.=" where wng.dmn_id(+)=ps_wing and brn.dmn_id(+)=ps_brnch_id ";
	$query.="and  sec.dmn_id(+)=ps_sctn_id and ct.dmn_id(+)=sr_sc_st_n ";
	$query.="and cdr.dmn_id(+)=ps_cdr_id and ps_wing like '$wing' and ps_flg='W' and ";
	$query.=" ps_brnch_id like '$branch' and
              ps_sctn_id like '$section' and
              ps_cdr_id like '$cadre'    and
              nvl(ps_room_no,'TVM') like '$hq'  and
              nvl(sr_sc_st_n,'GL') like '$cat' ";

              
     if (!(isset($_POST["nm"])))
       {
      $query.=" group by ";
      $query.=(isset($_POST["w"])?" wng.dmn_dscrptn,":"");
	  $query.=(isset($_POST["b"])?" brn.dmn_dscrptn,":"");
	  $query.=(isset($_POST["s"])?" sec.dmn_dscrptn,":"");
	  //$query.=(isset($_POST["c"])?" ps_cdr_,":"");
	  $query.=(isset($_POST["c"])?" cdr.dmn_dscrptn,":"");
	  $query.=(isset($_POST["r"])?" ps_room_no,":"");
	  $query.=(isset($_POST["ct"])?" ct.dmn_dscrptn,":"");
	  $query=substr($query,0,strlen($query)-1)." ";
       } 

      $query.=" order by ";
      $query.=(isset($_POST["w"])?" wng.dmn_dscrptn,":"");
	  $query.=(isset($_POST["b"])?" brn.dmn_dscrptn,":"");
	  $query.=(isset($_POST["s"])?" sec.dmn_dscrptn,":"");

	  $query.=(isset($_POST["r"])?" ps_room_no,":"");
	  $query.=(isset($_POST["ct"])?" ct.dmn_dscrptn,":"");
	  if (!(isset($_POST["nm"])))
	  $query.=(isset($_POST["c"])?" cdr.dmn_dscrptn,":"");
	  else
	  $query.=" ps_cdr_id,ps_nm,";
	  
	  $query=substr($query,0,strlen($query)-1)." ";

  // echo "<h1>$query</h1>";
   
    echo "<table class='floatlef' id='t01'>";
    echo "<tr>";
    if (isset($_POST["w"])) echo "<th>Wing</th>";
    if (isset($_POST["b"])) echo "<th>Branch</th>";
    if (isset($_POST["s"])) echo "<th>Section</th>";
    
    if (isset($_POST["r"])) echo "<th>HQ</th>";
    if (isset($_POST["ct"])) echo "<th>Category</th>";
    if (isset($_POST["c"])) echo "<th>Designation</th>";
    if (isset($_POST["nm"])) 
    	echo "<th>Employee name</th>";
    else
    	echo "<th>Employee count</th>";
    echo "</tr>";

    $statemen=oci_parse($conn,$query);
    oci_execute($statemen);

    $wingz="";
    $branchz="";
    $sectionz="";
    $cadrez="";
    $hqz="";
    $catz="";

    while( $row=oci_fetch_array($statemen))
    	{   

    		if (isset($_POST["w"])){
    		$wingzd='';
    		if($row['WING']!=$wingz)
       			{
       		$wingzd=$row['WING'];
        	$wingz=$row['WING'];
       			}
                                    }

            if (isset($_POST["b"])){                        
       		$branchzd='';
    		if($row['BRANCH']!=$branchz)
       			{
       		$branchzd=$row['BRANCH'];
        	$branchz=$row['BRANCH'];
       			}
       								}

       		if (isset($_POST["s"])){ 						
       		$sectionzd='';
    		if($row['SECTION']!=$sectionz)
       			{
       		$sectionzd=$row['SECTION'];
        	$sectionz=$row['SECTION'];
       			}
       								}
       		
            

       		if (isset($_POST["r"])){ 						
       		$hqzd='';
    		if($row['PS_ROOM_NO']!=$hqz)
       			{
       		$hqzd=$row['PS_ROOM_NO'];
        	$hqz=$row['PS_ROOM_NO'];
       			}
       								}

       		if (isset($_POST["ct"])){ 						
       		$catzd='';
    		if($row['CATEGORY']!=$catz)
       			{
       		$catzd=$row['CATEGORY'];
        	$catz=$row['CATEGORY'];
       			}
       								}

       		if (isset($_POST["c"])){ 
       		$cadrezd='';
    		if($row['CADRE']!=$cadrez)
       			{
       		$cadrezd=$row['CADRE'];
        	$cadrez=$row['CADRE'];
       			}
       								}
    

    
    $tot=$row['TOT'];
    echo "<tr>";
    if (isset($_POST["w"])) echo "<td>$wingzd</td>";
    if (isset($_POST["b"])) echo "<td>$branchzd</td>";
    if (isset($_POST["s"])) echo "<td>$sectionzd</td>";
    
    if (isset($_POST["r"])) echo "<td>$hqzd</td>";
    if (isset($_POST["ct"])) echo "<td>$catzd</td>";
    if (isset($_POST["c"])) echo "<td>$cadrezd</td>";
    echo "<td>$tot</td>";
    echo "</tr>";
    	}
    echo "</table>";

 }

 ?>
 <?php
if (!(isset($query)))
$query="select ps_nm from prsnl_infrmtn_systm";
$nstr=$query;
  $nstr = preg_replace('/[\r\n\t\s]/', '^', $nstr);
  $nstr = preg_replace('/[+]/', '__', $nstr);
  $nstr = preg_replace('/[\']/', 'nmn', $nstr);
  echo "<a href='getthisinexcel.php?modq=$nstr'>Download as excel</a> ";
?>
</body>


