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
	<style>
		#error 
			{color: #FF0000;}
		#nameinv
			{visibility:hidden;}
		#namett
			{visibility:hidden;}
		#bl
		   {
			   font-size:15;
		   }
		body
			{
			/*background-image:url('cag/office.png');
			background-position: center;
			background-repeat:no-repeat;
			background-size: cover;
			background-color:yellow;*/
			}
		#bio
			{
			background-color: #ccffcc;
			/*position: relative;*/
			}
		#pay
			{
			background-color: #66ff99;
			}
		f,#f
			{
			background-color: coral;
			font-size:18px;
			}
		#ima
			{
			float:right;
			}
		.firstbox
			{
			position:relative;
			left:80px;
			}
		warn
            {
                color:red;
                font-size: 48px;
            }
	</style>

	<script>
			function myfunc()
				{
					alert('done');
				}
	</script>
	<h1>Welcome  <?= $fgmembersite->UserFullName(); ?>!</h1>
</head>


<body>
	<input type="text" name="name" id="nameinv">  

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
		if (!(isset($_SESSION["y"])))  $_SESSION["y"]='';
		if (!(isset($_SESSION["z"])))  $_SESSION["z"]='';
		$go_ahead=0;
		$inc_elem=33;
		$err_id="";
		$err_nm="";
		if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('name',$_POST)))
			{  //echo 'namebox='.$_POST["name"].'  and quer_res='.$_SESSION["y"];
			if(!($_POST["name"]==$_SESSION["y"]))
			$_SESSION["z"]=test_input($_POST["name"]);;
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
			 
	    }   
		
		
	}
	

?>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<fieldset id="bio" >
<legend style="position:centered;">Bio Data</legend>
    <span id="error"> <?php echo '<f>'.$err_nm.'</f>';?>  </span>     <img src="cag/iii.jpg" id="ima" alt="No Photo" style="width:152px;height:195px;">
<br>
<f>Office ID</f>   : <input type="text" name="id" id="id" >  <span id="error"> <?php echo '<f>'.$err_id.'</f>';?>  </span>
<f> Name </f>: <input type="text" name="name" id="name">

<f>KLTVA Number</f>: <input type="text" name="kltva" id="kltva">
<f>Sex type</f>    : <input type="text" name="mf" id="mf">

<f>Blood group</f> : <input type="text" name="bldgrp" id="bldgrp">
<br>
<f>Address</f>     : <input type="text" name="addr1" id="addr1" size="60" style="position: relative;left: 10px;">
              <input type="text" name="addr2" id="addr2" size="60" style="position: relative;left: 10px;">
              <input type="text" name="addr3" id="addr3" size="60" class="firstbox">

<city style="position: relative;left: 80px;"><f>City </f>       : <input type="text" name="city" id="city"   size="40"  ></city>
<edqual style="position: relative;left: 80px;"><f>Edu. qualification </f>       : <input type="text" name="edqual" id="edqual"   size="40"  ></edqual>
</br>
<f>Wing</f>        : <input type="text" name="wing" id="wing" size="40">
<f>Branch</f>      :<input type="text" name="branchh" id="branchh" size="40">
<f>Section</f>		: <input type="text" name="level" id="level" size="40">
<br>
<f>Cadre</f>       : <input type="text" name="cadre" id="cadre" size="40" >
<f>HQ</f>       : <input type="text" name="hq" id="hq" size="20" >
<br>
</fieldset>

<fieldset id="pay">
<legend>Pay Details</legend>

<f>Basic Pay   :<input type="text" name="bpay" id ="bpay" size="20"></f>
<DA id="f">DA: <input type="text" name="da" id="da" size="20"></DA>
<TA id="f">TA: <input type="text" name="ta" id="ta" size="20"></TA>
<DAONTA id="f">DA on TA: <input type="text" name="daonta" id="daonta" size="20"></DAONTA>
<HRA id="f">HRA:    <input type="text" name="hra" id="hra" size="20" style="position: relative;left:32px"></HRA>
<GPF id="f" style="position: relative;left:32px">GPF:    <input type="text" name="gpf" id="gpf" size="20" ></GPF>

<br>

<CGGIS id="f" >CGGIS:    <input type="text" name="cggis" id="cggis" size="20" ></CGGIS>
<CGHS id="f" >CGHS:    <input type="text" name="cghs" id="cghs" size="20" ></CGHS>
<licence id="f" >License Fee:    <input type="text" name="licence" id="licence" size="20" ></licence>
<protax id="f" >Professional Tax:    <input type="text" name="pt" id="pt" size="20" ></protax>
<IT id="f" >Income Tax:    <input type="text" name="it" id="it" size="20" ></IT>

<br>
<ITSUR id="f" >IT Surcharge:    <input type="text" name="itsur" id="itsur" size="20" ></ITSUR>
<Trvry id="f" >Total Recovery:    <input type="text" name="tr" id="tr" size="20" ></Trvry>
<netpay id="f" >Net Pay:    <input type="text" name="net" id="net" size="20" ></netpay>
<Tier1 id="f" >TierI:    <input type="text" name="t1" id="t1" size="20" ></Tier1>



</fieldset>



<input type="submit" name="submit" value="Search"> 

</form>
<f><a href='orarepo.php'>Report of Employees </a></f>
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
			 $conn=oci_connect("km","rt","localhost/test2");
			 
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
						like '".strtolower($name)."%'".$subquery;
						   
			 
						   
						   
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
						 echo 'document.getElementById("ima").src=\'photo_cag/'.$row["PS_IDN"].'\.jpg\'';
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
	return $data;
	}
	
?>




 				
					




</body>