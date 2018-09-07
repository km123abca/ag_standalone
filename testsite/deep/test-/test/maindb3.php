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
 							.showswitch
 							{
 								position: absolute;
 								float:left;
 								visibility: hidden;
 							}
 							legend
 							{
 							font-weight: bold;
 							font-size: 24px;
 							}
 							.pcl
 							{
 								clear:left;
 								float:left;
 							}
 							.fll
 							{
 								width:100%;
 							}
 							.fl
 							{
 								width:100%;
 								float:left;
 								font-weight: bold;
 							}
 							.lg,.md,.sm
 							{
 							/*border:2px solid black;*/
 							float:left;
 							font-weight: bold;
 							}
 							.plg,.pmd,.psm
 							{
 							/*border:2px solid black;*/
 							float:left;
 							font-weight: bold;
 							}
							@media(min-width: 992px)
 								{ 
 								.lg
 									{
 									width: 16.66%;		    
 								    
 									}
 								.plg
 									{
 									width:50%;
 									}
       							}
 							@media(min-width:768px) and (max-width:992px)
 								{ 
 									.md
 									{
 									width: 25%;
 									
 									}
 									.pmd
 									{
 									width:100%;
 									}
 								}
 							@media(max-width: 767px)
 								{ 
 									.sm
 									{
 										width: 50%;
 										
 									}
 									.psm
 									{
 									width:100%;
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
							fieldset
							    {
							    	clear:left;
							    }
							#pay
								{
								background-color: #66ff99;
								}
/*
							f,#f
								{
								background-color: gray;
								font-size:18px;
								font-weight:bold;
								}
*/
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
            function altervis(toshow,tohide)
			    {
			    	var showdoc=document.getElementById(toshow).style;
			    	var hidedoc=document.getElementById(tohide).style;
                console.log("entered altervis with toshow="+toshow);
                console.log('enterd altervis with tohide='+tohide);
			    	showdoc.position='relative';
			    	showdoc.float='left';
			    	showdoc.visibility='visible';

			    	hidedoc.position='absolute';
			    	hidedoc.float='left';
			    	hidedoc.visibility='hidden';

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

			function vallist(col,elem,opto='no')
				{
				
				//console.log(rltn);
				
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
					document.getElementById(elem).innerHTML=this.responseText;
							}
						};
				if (opto!='desc')
				xmlhttp.open("GET", "vallist.php?q=" + col, true);
			    else
			    xmlhttp.open("GET", "vallist.php?q=" + col+"&b="+'desc', true);
		    	 xmlhttp.send();
					
				}

			function clrdets()
				{
					for( var ind in document.getElementsByClassName("inp"))
						document.getElementsByClassName("inp")[ind].value="";
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
            $_SESSION["panno"]=test_input($_POST["panno"]);
            $_SESSION["cat"]=test_input($_POST["cat"]);
            $_SESSION["edqual"]=test_input($_POST["edqual"]);
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
<button type="button" onclick="clrdets()">clear</button>
<input type="submit" name="submit" value="Search">  
<img src="cag/iii.jpg" id="ima" alt="No Photo" >
<fieldset id="bio" >
<legend  id="bioo">Bio Data</legend>
     
<t1 class="plg pmd psm lab1"><f>Office ID</f></t1>
<inp class="plg pmd psm">:<input type="text" name="id" id="id" class="inp"></inp>
<t2 class="plg pmd psm"><f> Name </f></t2>
<inp class="plg pmd psm">:<input type="text" name="name" id="name" class="inp"></inp>
<t3 class="plg pmd psm"><f>KLTVA Number</f></t3>
<inp class="plg pmd psm">:<input type="text" name="kltva" id="kltva" class="inp"></inp>
<t3 class="plg pmd psm"><f>PAN Number</f></t3>
<inp class="plg pmd psm">:<input type="text" name="panno" id="panno" class="inp"></inp>
<t4 class="plg pmd psm"><f>Sex type</f></t4>
<inp class="plg pmd psm">:<input type="text" name="mf" id="mf" class="inp"></inp>

<t4 class="plg pmd psm"><f>Mobile Number</f></t4>
<inp class="plg pmd psm">:<input type="text" name="mobl" id="mobl" size="40" class="inp" ></inp>


<t4 class="plg pmd psm"><f>Category</f></t4>
<inp class="plg pmd psm">:<input type="text" name="cat" id="cat" size="40" class="inp" list="clist"></inp>
<datalist id="clist"></datalist>

<t41 class="plg pmd psm"><f>Date of Birth</f></t41>
<inp class="plg pmd psm">:<input type="text" name="dob" id="dob" class="inp"></inp>
<t5 class="plg pmd psm"><f>Blood group</f></t5>
<inp class="plg pmd psm">:<input type="text" name="bldgrp" id="bldgrp" class="inp"></inp>
<t6 class="fl pcl">
<f>Address</f>     : <input type="text" name="addr1" id="addr1" size="51" class="inp"></t6>
                     <t7 class="fl pcl">
                     <input type="text" name="addr2" id="addr2" size="60" class="inp">
                     </t7>
                     <t8 class="fl pcl">
                     <input type="text" name="addr3" id="addr3" size="60" class="firstbox inp" >
                     </t8>

<city id="citty" class="plg pmd psm"><f>City </f></city>
<inp class="plg pmd psm">:<input type="text" name="city" id="city"   size="40" class="inp"></inp>
<edqual id="edquall" class="plg pmd psm"><f>Edu. qualification </f></edqual>
<inp class="plg pmd psm">:<input type="text" name="edqual" id="edqual"   
                            list="edlist" size="40" class="inp"></inp>
                            <datalist id="edlist"></datalist>
</fieldset>

<button type="button" id="offbutton" class="showswitch" 
         onclick="altervis('bio2','offbutton')">show Office details</button>
 

<fieldset id='bio2'>
<legend > Office details 
<button type="button" id="offbutton2" class="hideswitch" 
        onclick="altervis('offbutton','bio2')">show less</button>
</legend>
 <script >
 	makelistt('%','02','winglist','0','0');
 	makelistt('%','03','branlist','0','0');
 	makelistt('%','17','sectionlist','0','0');
 	makelistt('%','01','cadrelist','0','0');
 	vallist('ps_floor','paylist');
 	vallist('ps_grp_id','grplist');
 	vallist('sr_sc_st_n','clist','desc');
 	vallist('PS_EDCTNL_QLFCTN1','edlist');
 </script>


  <t71 class="plg pmd psm"><f>Level</f></t71>
 <inp class="plg pmd psm">:<input type="text" name="paylevel" id="paylevel"  list="paylist"
                            size="40"  class="inp"> 
                            <datalist id="paylist"></datalist>
 </inp>

 <t7 class="plg pmd psm"><f>Wing</f></t7>
 <inp class="plg pmd psm">:<input type="text" name="wing" id="wing" list="winglist" 
                      size="40" 
                      onchange="makelistt('%','03','branlist','wing','0')" class="inp"> </inp>   
                      <!-- onchange="makelistt('%','03','branlist','wing','0')" -->
 
<datalist id="winglist"></datalist>
<t7 class="plg pmd psm"><f>Branch</f></t7>
<inp class="plg pmd psm">:<input type="text" name="branchh" id="branchh" class="inp"
                     list="branlist" size="40" onchange="makelistt('%','17','sectionlist','branchh','0')"></inp>
 
<datalist id="branlist"></datalist>
<t7 class="plg pmd psm">
<f>Section</f>
</t7>
<inp class="plg pmd psm">:<input type="text" name="level" id="level" list="sectionlist" size="40" class="inp">
</inp>

<datalist id="sectionlist"></datalist>
<t7 class="plg pmd psm">
<f>Cadre</f> 
</t7>
<inp class="plg pmd psm">:<input type="text" name="cadre" id="cadre" size="40" list="cadrelist" class="inp"></inp>

<datalist id="cadrelist"></datalist>

<t7 class="plg pmd psm">
<f>HQ</f>      
 </t7>
<inp class="plg pmd psm">:<input type="text" name="hq" id="hq" size="20" list="hqlist" class="inp" >
</inp>

<datalist id="hqlist">
	<option value='TVM'> <option value='TCR'> <option value='KDE'><option value='KTM'><option value='EKM'>
</datalist>

<t42 class="plg pmd psm"><f>Working/Non Working</f></t42>
<inp class="plg pmd psm">:<input type="text" name="wonw" id="wonw" class="inp"></inp>


<t43 class="plg pmd psm"><f>Group</f></t43>
<inp class="plg pmd psm">:<input type="text" name="grpid" id="grpid" class="inp" list="grplist"></inp>
<datalist id="grplist"></datalist>

<t43 class="plg pmd psm"><f>Date of joining CAG</f></t43>
<inp class="plg pmd psm">:<input type="text" name="doj" id="doj" class="inp" ></inp>

<t43 class="plg pmd psm"><f>Entry Cadre</f></t43>
<inp class="plg pmd psm">:<input type="text" name="eci" id="eci" class="inp" ></inp>

<t43 class="plg pmd psm"><f>Date of Retirement</f></t43>
<inp class="plg pmd psm">:<input type="text" name="dor" id="dor" class="inp" ></inp>

<t43 class="plg pmd psm"><f>Billing Unit</f></t43>
<inp class="plg pmd psm">:<input type="text" name="bunit" id="bunit" class="inp" size="40" ></inp>

<t43 class="plg pmd psm"><f>GPF No</f></t43>
<inp class="plg pmd psm">:<input type="text" name="gpfno" id="gpfno" class="inp" size="20" ></inp>

<t43 class="plg pmd psm"><f>Accommodation</f></t43>
<inp class="plg pmd psm">:<input type="text" name="acomm" id="acomm" class="inp" size="20" ></inp>

<t43 class="plg pmd psm"><f>Deputation Location</f></t43>
<inp class="plg pmd psm">:<input type="text" name="depplace" id="depplace" class="inp" size="60" ></inp>

<t43 class="plg pmd psm"><f>Deputation Designation</f></t43>
<inp class="plg pmd psm">:<input type="text" name="depdes" id="depdes" class="inp" size="60" ></inp>

<t43 class="plg pmd psm"><f>Deputation From</f></t43>
<inp class="plg pmd psm">:<input type="text" name="dfp" id="dfp" class="inp" size="60" ></inp>


</fieldset>

<button type="button" id="offbutton3" class="showswitch" 
         onclick="altervis('pay','offbutton3')">show Pay details</button>

<fieldset id="pay">
<legend>Pay Details
<button type="button" id="offbutton22" class="hideswitch" 
        onclick="altervis('offbutton3','pay')">show less</button>
 </legend>

<bas class="lg md sm">Basic Pay</bas >  
 <bas class="lg md sm">:<input type="text" name="bpay" id ="bpay" size="20" class="inp"></bas>
<DA  class="lg md sm">DA </DA>
<inp  class="lg md sm">:<input type="text" name="da" id="da" size="20" class="inp"></inp>
<TA  class="lg md sm">TA </TA>
<inp  class="lg md sm">:<input type="text" name="ta" id="ta" size="20" class="inp"></inp>
<DAONTA  class="lg md sm">DA on TA </DAONTA>
<inp  class="lg md sm">:<input type="text" name="daonta" id="daonta" size="20" class="inp"></inp>
<HRA  class="lg md sm">HRA</HRA>
<inp  class="lg md sm">:<input type="text" name="hra" id="hra" size="20" class="inp" ></inp>
<GPF  class="lg md sm">GPF</GPF>
<inp  class="lg md sm">:<input type="text" name="gpf" id="gpf" size="20"  class="inp"></inp>



<CGGIS  class="lg md sm">CGGIS</CGGIS>
<inp  class="lg md sm">:<input type="text" name="cggis" id="cggis" size="20"  class="inp"></inp>
<CGHS  class="lg md sm">CGHS  </CGHS>
<inp  class="lg md sm">:<input type="text" name="cghs" id="cghs" size="20"  class="inp"></inp>
<licence  class="lg md sm">License Fee</licence>
<inp  class="lg md sm">:<input type="text" name="licence" id="licence" size="20" class="inp"></inp>
<protax  class="lg md sm">Professional Tax</protax>
<inp  class="lg md sm">:<input type="text" name="pt" id="pt" size="20" class="inp"></inp>
<IT  class="lg md sm">Income Tax </IT>
<inp  class="lg md sm">:<input type="text" name="it" id="it" size="20" class="inp"></inp>


<ITSUR  class="lg md sm">IT Surcharge </ITSUR>
<inp  class="lg md sm">:<input type="text" name="itsur" id="itsur" size="20" class="inp"></inp>
<Trvry  class="lg md sm">Total Recovery</Trvry>
<inp  class="lg md sm">:<input type="text" name="tr" id="tr" size="20" class="inp"></inp>
<netpay  class="lg md sm">Net Pay</netpay>
<inp  class="lg md sm">:<input type="text" name="net" id="net" size="20" class="inp"></inp>
<Tier1  class="lg md sm">TierI</Tier1>
<inp  class="lg md sm">:<input type="text" name="t1" id="t1" size="20" class="inp"></inp>

<bnk  class="lg md sm">Bank Name</bnk>
<inp  class="lg md sm">:<input type="text" name="bnk" id="bnk" size="20" class="inp"></inp>



</fieldset>




</form>
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
	        //echo "access exists for $current_user <br>";
	        $awings=$row['WING'];
	        $abranches=$row['BRANCH'];
	        $asections=$row['SECTIONN'];
	        $ids=$row['IDS'];
	        if  ($row["IDNO"]=='basic') $ids=$current_user;
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
	        $searchcrt.=" and nvl(lower(ps_frst_nm),'%') like nvl('$id2search','$noval') ";

            $id2search=strtolower($_SESSION["mf"]);
	        $searchcrt.=" and nvl(lower(ps_sx_typ),'%') like nvl('$id2search','$noval') ";

            $id2search=getdesc($_SESSION["wing"],$conn);
            //echo 'hello'.$_SESSION["wing"];
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(ps_wing),'%') like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["branchh"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(ps_brnch_id),'%') like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["section"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(ps_sctn_id),'%') like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["cat"],$conn);
	        $id2search=strtolower($id2search);
	        //echo 'hi'.$id2search;
	        $searchcrt.=" and nvl(lower(sr_sc_st_n),'%') like nvl('$id2search','$noval') ";

	        $id2search=getdesc($_SESSION["cadre"],$conn);
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(ps_cdr_id),'%') like nvl('$id2search','$noval') ";

	        $id2search=$_SESSION["hq"];
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(ps_room_no),'%') like nvl('$id2search','$noval') ";

	        $id2search=$_SESSION["panno"];
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(ps_bldng),'%') like nvl('$id2search','$noval') ";

	          $id2search=$_SESSION["edqual"];
	        $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(PS_EDCTNL_QLFCTN1),'%') like nvl('$id2search','$noval') ";
				
				/**/
			
			$query = "SELECT ps_nm,
			                 ps_idn,
			                 ps_frst_nm,
			                 ps_sx_typ,
			                 ps_bld_grp,
			                 PS_PRSNT_ADDRSS1 PS_HM_TWN_ADDRSS1,
			                 PS_PRSNT_ADDRSS2 PS_HM_TWN_ADDRSS2,
  			                 PS_PRSNT_ADDRSS3 PS_HM_TWN_ADDRSS3,
  			                 PS_EDCTNL_QLFCTN1,
  			                 PS_PRSNT_CTY PS_HM_CTY,
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
  			                 ps_room_no,

  			                 ps_bldng,
  			                 ps_floor,
  			                 ps_mobile_no,
  			                 ps_tele_office,
  			                 ps_flg,
  			                 ps_eml_addrss,
  			                 ps_dt_of_brth,
  			                 ps_grp_id,
  			                 sr_entry_cdr_id,
  			                 sr_dt_of_jn,
  			                 sr_dt_of_jn_ssn,
  			                 sr_trnsfr_stts,
  			                 sr_yr_of_pssng_sog,
  			                 sr_yr_of_pssng_ra,
  			                 sr_ltst_prmtn_cdr_id,
  			                 sr_ltst_dt_of_prmtn,
  			                 sr_ltst_dt_of_prmtn_ssn,
  			                 sr_prbtn_dt,
  			                 sr_prbtn_ssn,
  			                 sr_cnfrmtn_pst,
  			                 sr_dpttn_cdr_id,
  			                 cm_unt_cd,
  			                 cm_dli,
  			                 cm_dni,
  			                 cm_chq_pd,
  			                 cm_rti_nrti,
  			                 cm_clms_flg,
  			                 cm_cghs_flg,
  			                 sr_acp_stts,
  			                 ps_prsnt_pn_cd,
  			                 sr_snrty,
  			                 sr_sc_st_n,
  			                 SR_LTST_DT_OF_PRMTN_JN_DT,
  			                 SR_DT_OF_RTRMNT,
  			                 PS_PRNT_OFFICE,
  			                 PS_GPFNO,
  			                 PS_SLNO,
  			                 PS_BNK_NM,
  			                 SR_DT_OF_JN_CAG,
  			                 PS_PAO_NO,
  			                 PS_BNK_ACCNT_NO,
  			                 CM_ACCMMDTN,
  			                 CM_TA_RQRD_FLG,
  			                 PS_DPTTN_DESIG,
  			                 PS_DPTTN_PLACE,
  			                 PS_DPTTN_FR_PLACE,
  			                 PS_GRADUATE,
  			                 PS_EXSM_FLG,
  			                 SR_ACP_STTS2,
  			                 SR_ACP_STTS3

  			            FROM prsnl_infrmtn_systm,
  			            						(select * from clms_erng_yrfl where 
  			           			er_mnth_of_acnt in	 (select max(er_mnth_of_acnt) from clms_erng_yrfl)
  			           						     ) aa
  			            where 
  			            	 er_idn(+)=ps_idn and  
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
						$pan_no=$row["PS_BLDNG"];
						$paylevel=$row["PS_FLOOR"];
						$dob=$row["PS_DT_OF_BRTH"];
						$wonw=($row["PS_FLG"]=="W")?"Working":"Not Working";
						$grpid=$row["PS_GRP_ID"];
						$doj=$row["SR_DT_OF_JN"];
						$entrycdr=$row["SR_ENTRY_CDR_ID"];
						$dor=$row["SR_DT_OF_RTRMNT"];
						$bunit=$row["CM_UNT_CD"];
						$gpfno=$row["PS_GPFNO"];
						$acomm=$row["CM_ACCMMDTN"];
						$cat=$row["SR_SC_ST_N"];//query done
						$depplace=$row["PS_DPTTN_PLACE"];
						$depdes=$row["PS_DPTTN_DESIG"];
						$dfp=$row["PS_DPTTN_FR_PLACE"];
						$bnk=$row["PS_BNK_NM"];
						$mobl=$row["PS_MOBILE_NO"];
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
						 echo 'document.getElementById("dob").value=\''.$dob.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("wonw").value=\''.$wonw.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("grpid").value=\''.$grpid.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("doj").value=\''.$doj.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("dor").value=\''.$dor.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("acomm").value=\''.$acomm.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("gpfno").value=\''.$gpfno.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("eci").value=\''.descr($entrycdr,$conn).'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("cat").value=\''.descr($cat,$conn).'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("bunit").value=\''.descr($bunit,$conn).'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("panno").value=\''.$pan_no.'\'';
					     echo '</script>';
					     echo '<script>';
						 echo 'document.getElementById("mobl").value=\''.$mobl.'\'';
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

						 echo '<script>';
						 echo 'document.getElementById("depplace").value=\''.descr($depplace,$conn).'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("depdes").value=\''.descr($depdes,$conn).'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("dfp").value=\''.descr($dfp,$conn).'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("bnk").value=\''.$bnk.'\'';
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

						   echo '<script>';
						   echo 'document.getElementById("paylevel").value=\''.$paylevel.'\'';
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

function getdesc($desc,$conn,$opto='no')
	    {
	    	//require_once("./include/membersite_config.php");
           //$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	      $desc=strtoupper(($desc)); 
          if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
		if ($opto!='usual')
	      $query="select dmn_id from estt_dmn_mstr where 
	         upper(replace(dmn_dscrptn,'&','and')) like"." '$desc'";
	    else
	      $query="select dmn_id from estt_dmn_mstr where 
	         upper((dmn_dscrptn)) like"." '$desc'";

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
	
?>




 				
					




</body>