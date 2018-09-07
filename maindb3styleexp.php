<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>
<head>
<!--<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />-->
<meta name="viewport" content="width=device-width,initial-scale=1">
<!--
<link rel="STYLESHEET" type="text/css" href="maindb3.css" /> 
-->
<style>
							
							*
 							{word-wrap:break-word;
 							 box-sizing:border-box;
 							}
 							.lg,.md,.sm
 							{
 							border:2px solid black;
 								
 							float:left;
 							}
							@media(min-width: 992px)
 								{ 
 								.lg
 									{
 									width: 32%;
 								    
 								    
 									}
       							}
 							@media(min-width:768px) and (max-width:992px)
 								{ 
 									.md
 									{
 									width: 50%;
 									
 									}
 								}
 							@media(max-width: 767px)
 								{ 
 									.sm
 									{
 										width: 100%;
 										
 									}
 								}

 							#error 
								{
								color: #FF0000;
								}
							#namett
								{
								visibility:hidden;
								}
							#bl
		  						{
			   					font-size:15;
		   						}
		   					#bio
								{
								background-color: #ccffcc;
								}
							#pay
								{
								background-color: #66ff99;
								}
							f,#f
								{
								background-color: gray;
								font-size:18px;
								font-weight:bold;
								}
							#ima
								{
								float:right;
								width:152px;
								height:195px;
								}
							warn
            					{
                				color:red;
                				font-size: 48px;
            					}
            				#bioo
            					{           	
            					position:centered;
            					}
            				#offheading
								{
								font-size:200%;
								background-color:yellow;
								text-align:center;
								}

</style>
       



	<script>
	        
			function myfunc()
				{
					alert('done');
				}

			function makelistt(rltn,typ,dest,rlget,typget)
				{
				if (rlget!='0')
					rltn=document.getElementById(rlget).value;
				if (typget!='0')
					typ=document.getElementById(typget).value;
				//console.log(rltn);
				if (rltn.length!=0)
					{
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
					document.getElementById(dest).innerHTML=this.responseText;
							}
						};
				xmlhttp.open("GET", "makelistt.php?q=" + rltn+"&r="+ typ, true);
		    	 xmlhttp.send();
					}
				}
	</script>
	<h1>Welcome  <?= $fgmembersite->UserFullName(); ?>!</h1>
</head>


<body>
	  

	<?php
	    $current_user=$fgmembersite->Userid();
		//require_once('login.php');
		//echo $_SESSION['GO'];
		//session_start();
		if(!isset($_SESSION["x"]))     //WE ARE SETTING THE SESSION VARIABLE X HERE .FROM NOW ON X WILL LIVE AS LONG AS THE WEB PAGE IS ACTIVE
			{
			$_SESSION["x"]=1;
			//echo "session has been set";
			}
		//$_SESSION["norole"]="";
		if (!(isset($_SESSION["y"])))  $_SESSION["y"]='o';
		if (!(isset($_SESSION["z"])))  $_SESSION["z"]='';
		if (!(isset($_SESSION["per"])))  $_SESSION["per"]='';
		$go_ahead=0;
		$inc_elem=33;
		$err_id="";
		$err_nm="";
		//if (($go_ahead==0)&&(empty($_POST["name"]))) $_SESSION["per"]="";
		if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('name',$_POST)))
			{  //echo 'namebox='.$_POST["name"].'  and quer_res='.$_SESSION["y"];
			if(!($_POST["name"]==$_SESSION["y"]))
					{
			$_SESSION["z"]=test_input($_POST["name"]);
			$_SESSION["id"]=test_input($_POST["id"]);
			$_SESSION["kltva"]=test_input($_POST["kltva"]);
			$_SESSION["mf"]=test_input($_POST["mf"]);
			$_SESSION["wing"]=test_input($_POST["wing"]);
			$_SESSION["branchh"]=test_input($_POST["branchh"]);
            $_SESSION["section"]=test_input($_POST["level"]);
            $_SESSION["cadre"]=test_input($_POST["cadre"]);
            $_SESSION["hq"]=test_input($_POST["hq"]);
					}
					/*
			if (empty($_POST["name"]))  
				{
				$go_ahead=0;
				$err_nm="Name cannot be empty";
				$err_id="ID cannot be empty";
				}
			
		if (!((empty($_POST["name"])))) {$go_ahead=1;}
		if (str_replace(' ','',($_POST["name"]))=="") 
		{	
	        $go_ahead=0;
			$err_nm="Name cannot be empty";
			$err_id="ID cannot be empty";
			 
	    }  */ 
	 {$go_ahead=1;}	
		
	}
	

?>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<img src="cag/iii.jpg" id="ima" alt="No Photo" >
<fieldset id="bio" >
<legend  id="bioo">Bio Data</legend>

<span id="error"> <?php echo '<f>'.$err_nm.'</f>';?>  </span>     
<f>Office ID</f>   : <input type="text" name="id" id="id" >  <span id="error"> <?php echo '<f>'.$err_id.'</f>';?>  </span>
<f> Name </f>: <input type="text" name="name" id="name">
<f>KLTVA Number</f>: <input type="text" name="kltva" id="kltva">
<f>Sex type</f>    : <input type="text" name="mf" id="mf">
<f>Blood group</f> : <input type="text" name="bldgrp" id="bldgrp">
<f>Address</f>     : <input type="text" name="addr1" id="addr1" size="60" >
                     <input type="text" name="addr2" id="addr2" size="60" >
                     <input type="text" name="addr3" id="addr3" size="60" class="firstbox">
<city id="citty" ><f>City </f>: <input type="text" name="city" id="city"   size="40"  ></city>
<edqual id="edqual"><f>Edu. qualification </f>: <input type="text" name="edqual" id="edqual"   size="40"  ></edqual>
 <script >
 	makelistt('%','02','winglist','0','0');
 	makelistt('%','03','branlist','0','0');
 	makelistt('%','17','sectionlist','0','0');
 	makelistt('%','01','cadrelist','0','0');
 </script>
 
<f>Wing</f>        : <input type="text" name="wing" id="wing" list="winglist" 
                      size="40" 
                      onchange="makelistt('%','03','branlist','wing','0')">    
                      <!-- onchange="makelistt('%','03','branlist','wing','0')" -->
 <datalist id="winglist"></datalist>


<f>Branch</f>      :<input type="text" name="branchh" id="branchh" 
                     list="branlist" size="40" onchange="makelistt('%','17','sectionlist','branchh','0')">
<datalist id="branlist"></datalist>


<f>Section</f>		: <input type="text" name="level" id="level" list="sectionlist" size="40">
<datalist id="sectionlist"></datalist>

<f>Cadre</f>       : <input type="text" name="cadre" id="cadre" size="40" list="cadrelist">
<datalist id="cadrelist"></datalist>
<f>HQ</f>       : <input type="text" name="hq" id="hq" size="20" list="hqlist" >
<datalist id="hqlist">
	<option value='TVM'> <option value='TCR'> <option value='KDE'><option value='KTM'><option value='EKM'>
</datalist>

</fieldset>

<fieldset id="pay">
<legend>Pay Details</legend>

<BAS class="lg md sm">Basic Pay   :<input type="text" name="bpay" id ="bpay" size="20"></BAS>
<DA  class="lg md sm">DA: <input type="text" name="da" id="da" size="20"></DA>
<TA  class="lg md sm">TA: <input type="text" name="ta" id="ta" size="20"></TA>
<br>
<DAONTA  class="lg md sm">DA on TA: <input type="text" name="daonta" id="daonta" size="20"></DAONTA>
<HRA  class="lg md sm">HRA:    <input type="text" name="hra" id="hra" size="20" ></HRA>
<GPF  class="lg md sm">GPF:    <input type="text" name="gpf" id="gpf" size="20" ></GPF>



<CGGIS  class="lg md sm">CGGIS:    <input type="text" name="cggis" id="cggis" size="20" ></CGGIS>
<CGHS  class="lg md sm">CGHS:    <input type="text" name="cghs" id="cghs" size="20" ></CGHS>
<licence  class="lg md sm">License Fee:    <input type="text" name="licence" id="licence" size="20" ></licence>
<protax  class="lg md sm">Professional Tax:    <input type="text" name="pt" id="pt" size="20" ></protax>
<IT  class="lg md sm">Income Tax:    <input type="text" name="it" id="it" size="20" ></IT>


<ITSUR  class="lg md sm">IT Surcharge:    <input type="text" name="itsur" id="itsur" size="20" ></ITSUR>
<Trvry  class="lg md sm">Total Recovery:    <input type="text" name="tr" id="tr" size="20" ></Trvry>
<netpay  class="lg md sm">Net Pay:    <input type="text" name="net" id="net" size="20" ></netpay>
<Tier1  class="lg md sm">TierI:    <input type="text" name="t1" id="t1" size="20" ></Tier1>



</fieldset>



<input type="submit" name="submit" value="Search"> 

</form>
<f><a href="testpdf2.php?u=<?php echo $_SESSION["per"]; ?>"  >Payslip </a></f>
<p><a href='welcomeuser.php'> <f>Main Page</f></a></p>
<p><a href='logout.php'> <f>Logout</f></a></p>



<!--
<form method="post">
     <input type="text" name="name" id="namett">
    <input type="text" name="name" id="namett">
    <input type="submit" name="test" id="test" value="RUN" /><br/>
</form>
-->
<?php
function testfun()
{
	echo "Your test function on button click is working";
    echo  '
						 <script>
					     	document.getElementById("nameinv").value=document.getElementById("name").value;
							 
					     </script>
						       ';
	return 0;
   
   
}

if(array_key_exists('test',$_POST)){
   $inc_elem=testfun();
}

?>

<?php
function restimage(){
echo  '
						 <script>
					     	document.getElementById("ima").src="cag/iiii.jpg";
							 
					     </script>
						       ';
					}
?>








<?php
//$inc_ele1=;

if ($go_ahead==1)
			{$go_ahead=0;
		     $name=$_SESSION["z"];
     		 $servername = "localhost/test2";
			 $username = "km";
			 $password = "rt";
			 $dbname="myDB";
			 //$conn = new mysqli($servername, $username, $password,$dbname);
			 //$conn=oci_connect($username,$password,$servername);
			 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
			 
			 if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}



				//Access analysis: generating the subquery for access control
			$query="select a.* from access_mazter a,role_mazter 
			        where a.idno=role and usr='$current_user'";
			$statemen=oci_parse($conn,$query);
	        oci_execute($statemen);
	        if( $row=oci_fetch_array($statemen))
	        	{
	        echo "access exists for $current_user <br>";
	        $awings=$row['WING'];
	        $abranches=$row['BRANCH'];
	        $asections=$row['SECTIONN'];
	        $ids=$row['IDS'];
	        if  ($row["IDNO"]=='base') $ids=$current_user;
	        $subquery="and ( ";
	        foreach(explode(',',$awings) as $awing)
	        		{
            $subquery.=" ps_wing like '$awing' or";
	        		}
	        $subquery=substr($subquery, 0,-2).") and (";
	        foreach(explode(',',$ids) as $aid)
	        		{
            $subquery.="ps_idn like '$aid' or";
	        		}
	        $subquery=substr($subquery, 0,-2).") and (";
	        foreach(explode(',',$abranches) as $abranch)
	        		{
            $subquery.="ps_brnch_id like '$abranch' or";
	        		}
            $subquery=substr($subquery, 0,-2).") and (";
	        foreach(explode(',',$asections) as $asection)
	        		{
            $subquery.="ps_sctn_id like '$asection' or";
	        		}
	        $subquery=substr($subquery, 0,-2).")";
	        //echo $subquery;
	            }
	        else
	        	{//echo 'no access';
	             
	             //echo '';
	             die('<br><warn> You have no role defined, hence you cant search</warn><br>');
	             }
	         //Access analysis

	        $id2search=$_SESSION["id"];
	        $noval="%";
            $searchcrt=" and ps_idn like nvl('$id2search','$noval') ";	

            $id2search=strtolower($_SESSION["kltva"]);
	        $searchcrt.=" and lower(ps_frst_nm) like nvl('$id2search','$noval') ";

            $id2search=strtolower($_SESSION["mf"]);
	        $searchcrt.=" and lower(ps_sx_typ) like nvl('$id2search','$noval') ";

            $id2search=getdesc($_SESSION["wing"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and lower(ps_wing) like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["branchh"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and lower(ps_brnch_id) like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["section"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and lower(ps_sctn_id) like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["cadre"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and lower(ps_cdr_id) like nvl('$id2search','$noval') ";

	        $id2search=$_SESSION["hq"];
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and lower(ps_room_no) like nvl('$id2search','$noval') ";
				
				/**/
			
			$query = "SELECT ps_nm,
			                 ps_idn,
			                 ps_frst_nm,
			                 ps_sx_typ,
			                 ps_bld_grp,
			                 PS_HM_TWN_ADDRSS1,
			                 PS_HM_TWN_ADDRSS2,
  			                 PS_HM_TWN_ADDRSS3,
  			                 PS_EDCTNL_QLFCTN1,
  			                 PS_HM_CTY,
  			                 ps_cdr_id,
  			                 ps_wing,
  			                 ps_sctn_id,
  			                 ps_brnch_id,
  			                 ps_pca_bsc_jan06,
  			                 er_da,
  			                 er_ca,
  			                 er_cca,
  			                 er_hra,
  			                 er_gpf,
  			                 er_cggis,
  			                 er_cghs,
  			                 er_lcnc_fee,
  			                 er_pt,
  			                 er_it,
  			                 er_it_srchr,
  			                 er_rcvry_ttl,
  			                 er_nt_py,
  			                 tier1,
  			                 ps_room_no
  			            FROM prsnl_infrmtn_systm,clms_erng_yrfl
  			            where 
  			            	 er_idn(+)=ps_idn and  
  			            	 to_char(er_mnth_of_acnt,'MON-YY')=to_char(add_months(sysdate,-3),'MON-YY') and 
  			                 lower(ps_nm) 
						like '".strtolower($name)."%'".$searchcrt.$subquery;
						   
			 
						   
						   
			//echo $query;			   
			 echo "<br>";
			 $statemen=oci_parse($conn,$query);
	         oci_execute($statemen);
			 $results=array();
	         $num = oci_fetch_all($statemen, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			  oci_execute($statemen);
			$_SESSION["x"]+=1;
			
			//$num=$result->num_rows;
			//$num=oci_num_rows($statemen);
			if($_SESSION["x"]>$num) $_SESSION["x"]=1;
			if ($num==0) restimage();
			echo '<f id="bl"><b>'.$num.' records where found that matches your search string</b></f>';
			if ($num > 0) 
				{
					 //while($row = $result->fetch_assoc())
					while($num>0)	 
					 {  $row = oci_fetch_array($statemen);
				       if ($_SESSION["x"]==$num)
						 {
							 $_SESSION["y"]=$row["PS_NM"];
					    $cadre=$row["PS_CDR_ID"];
						$wing=$row["PS_WING"];
						$section=$row["PS_SCTN_ID"];
						$branchh=$row["PS_BRNCH_ID"];
						$blood=$row["PS_BLD_GRP"];
						$edqual=$row["PS_EDCTNL_QLFCTN1"];
						$er_da=$row["ER_DA"];
						$er_cca=$row["ER_CCA"];
						$er_ca=$row["ER_CA"];
						$er_hra=$row["ER_HRA"];
						$er_gpf=$row["ER_GPF"];
						$er_cggis=$row["ER_CGGIS"];
						$er_cghs=$row["ER_CGHS"];
						$er_lcnc_fee=$row["ER_LCNC_FEE"];
						$er_pt=$row["ER_PT"];
						$er_it=$row["ER_IT"];
						$er_it_srchr=$row["ER_IT_SRCHR"];
						$er_rcvry_ttl=$row["ER_RCVRY_TTL"];
						$er_nt_py=$row["ER_NT_PY"];
						$tier1=$row["TIER1"];
						$room=$row["PS_ROOM_NO"];
						$_SESSION["per"]=$row["PS_IDN"];
						 echo  '
						 <script>
					     	document.getElementById("name").value=\''.$row["PS_NM"].'\';
							'.
							'document.getElementById("id").value=\''.$row["PS_IDN"].'\''
							.'
					     </script>
						       ';
						 //echo $row["ps_sx_tp"];
                         echo '<script>';
                         echo 'document.getElementById("ima").src=\'images/'.'2190'.'\.jpg\'';
                         if (file_exists("photo_cag/".$row['PS_IDN'].".jpg"))
						 echo 'document.getElementById("ima").src=\'photo_cag/'.$row["PS_IDN"].'\.jpg\'';
						 //echo 'no photo';
						 echo '</script>';
						 
						 echo '<script>';
						 echo 'document.getElementById("mf").value=\''.$row["PS_SX_TYP"].'\'';
					     echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("kltva").value=\''.$row["PS_FRST_NM"].'\'';
						 echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("bldgrp").value=\''.$row["PS_BLD_GRP"].'\'';
						 echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("addr1").value=\''.$row["PS_HM_TWN_ADDRSS1"].'\'';
						 echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("addr2").value=\''.$row["PS_HM_TWN_ADDRSS2"].'\'';
						 echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("addr3").value=\''.$row["PS_HM_TWN_ADDRSS3"].'\'';
						 echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("city").value=\''.$row["PS_HM_CTY"].'\'';
						 echo '</script>';
						 echo '<script>';
						 echo 'document.getElementById("bpay").value=\''.$row["PS_PCA_BSC_JAN06"].'\'';
						 echo '</script>';
						 
						 
						 $query = "SELECT dmn_dscrptn from estt_dmn_mstr where dmn_id  = '".$cadre."'";
						 $statemen=oci_parse($conn,$query);
	                     oci_execute($statemen);
						 $row=oci_fetch_array($statemen);
						  
						    {//$row = $result->fetch_assoc();
						     echo '<script>';
						     echo 'document.getElementById("cadre").value=\''.$row["DMN_DSCRPTN"].'\'';
						      echo '</script>';
							}
							
						 $query =  "SELECT dmn_dscrptn from estt_dmn_mstr where dmn_id  = '".$wing."'";
						 $statemen=oci_parse($conn,$query);
	                     oci_execute($statemen);
						 $row=oci_fetch_array($statemen);
						  
						    {//$row = $result->fetch_assoc();
						     echo '<script>';
						     echo 'document.getElementById("wing").value=\''.$row["DMN_DSCRPTN"].'\'';
						      echo '</script>';
							}
							
						$query = "SELECT dmn_dscrptn from estt_dmn_mstr where dmn_id  = '".$section."'";
						 $statemen=oci_parse($conn,$query);
	                     oci_execute($statemen);
						 $row=oci_fetch_array($statemen);
						  
						    {//$row = $result->fetch_assoc();
						     echo '<script>';
						     echo 'document.getElementById("level").value=\''.$row["DMN_DSCRPTN"].'\'';
						      echo '</script>';
							}
							
							
						$query = "SELECT dmn_dscrptn from estt_dmn_mstr where dmn_id  = '".$blood."'";
						 $statemen=oci_parse($conn,$query);
	                     oci_execute($statemen);
						 $row=oci_fetch_array($statemen);
						  
						    {//$row = $result->fetch_assoc();
						     echo '<script>';
						     echo 'document.getElementById("bldgrp").value=\''.$row["DMN_DSCRPTN"].'\'';
						      echo '</script>';
							}

						$query = "SELECT dmn_dscrptn from estt_dmn_mstr where dmn_id  = '".$branchh."'";
						 $statemen=oci_parse($conn,$query);
	                     oci_execute($statemen);
						 $row=oci_fetch_array($statemen);
						  
						    {//$row = $result->fetch_assoc();
						     echo '<script>';
						     echo 'document.getElementById("branchh").value=\''.$row["DMN_DSCRPTN"].'\'';
						      echo '</script>';
							}	


						 echo '<script>';
						     echo 'document.getElementById("edqual").value=\''.$edqual.'\'';
						      
						  echo '</script>';

						  echo '<script>';
						  echo 'document.getElementById("da").value=\''.$er_da.'\'';
						  echo '</script>';

						  echo '<script>';
						  echo 'document.getElementById("ta").value=\''.$er_ca.'\'';
						  echo '</script>';

						  echo '<script>';
						   echo 'document.getElementById("daonta").value=\''.$er_cca.'\'';
						   echo '</script>';


						  echo '<script>';
						   echo 'document.getElementById("hra").value=\''.$er_hra.'\'';
						   echo '</script>';

						  echo '<script>';
						   echo 'document.getElementById("gpf").value=\''.$er_gpf.'\'';
						   echo '</script>';

						  echo '<script>';
						   echo 'document.getElementById("cggis").value=\''.$er_cggis.'\'';
						   echo '</script>';

						  echo '<script>';
						   echo 'document.getElementById("cghs").value=\''.$er_cghs.'\'';
						   echo '</script>';
							
						 echo '<script>';
						   echo 'document.getElementById("t1").value=\''.$tier1.'\'';
						   echo '</script>';

						   echo '<script>';
						   echo 'document.getElementById("hq").value=\''.$room.'\'';
						   echo '</script>';
							
							
							
						
							
						
							
						
							
							
						 }
							  // $inc_elee=$inc_ele;
							//   while($inc_elee==$inc_elem);
							   
						$num-=1; 
					 }
				}
			}

function test_input($data) 
	{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = htmlentities($data);
	return $data;
	}

function getdesc($desc,$conn)
	    {
	    	//require_once("./include/membersite_config.php");
           //$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	      $desc=strtoupper(($desc)); 
          if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
	      $query="select dmn_id from estt_dmn_mstr where 
	         upper(replace(dmn_dscrptn,'&','and')) like"." '$desc'";
	// echo $query;echo '<br>';
	// $query="select dmn_id from estt_dmn_mstr where lower(dmn_dscrptn) like 'economic & revenue sector audit'";
	// echo $query;	;echo '<br>';
	      $statemen=oci_parse($conn,$query);
	      oci_execute($statemen);
	      if ( $row=oci_fetch_array($statemen))
	 	    {   //echo $row["DMN_ID"];
	 		return $row["DMN_ID"];
	        }
	    //echo 'none found';
	      return '%';
	    }
	
?>




 				
					




</body>