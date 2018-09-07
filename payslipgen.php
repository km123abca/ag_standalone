
<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

function test_input($data) 
	{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = htmlentities($data);
	return $data;
	}

?>

<?php
$goahead=True;
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('empname',$_POST)))
{
if ($goahead)
  	{
  	$name=test_input($_POST["empname"]);
  	$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
  	if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}
  	$query="select ps_idn from prsnl_infrmtn_systm where ps_nm='$name'";


    $usertype=$fgmembersite->Userrole();
    $current_user=$fgmembersite->Userid();
    
    if ($usertype=='basic')
	   $query="select distinct ps_idn from prsnl_infrmtn_systm where ps_idn='$current_user' 
	           and ps_nm='$name' ";


  	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	$idno='nil';
	while($row=oci_fetch_array($statemen))
		{
    $idno=$row["PS_IDN"];
		}
	if ($idno=='nil')
		{
    echo '<h1>This individual dont exist in the database</h1>';
    echo "<a href='payslipgen.php'><strong>Go Back</strong></a>"."<br>";	
    die('');

		}
		$mnth=$_POST["month"];

	if ($mnth=='n')
		{
    echo '<h1>The month selected was not valid ,may be the employee had no salary entries in the database </h1>';
    echo "<a href='payslipgen.php'><strong>Go Back</strong></a>"."<br>";	
    die('');

		}



	require('fpdf/fpdf.php');
	$imagfile='images/logo.png';
	if (isset($_REQUEST["q"])) $imagfile='images/\''.$_REQUEST["q"]."'";

	$userid=$fgmembersite->Userid();
	if (isset($_REQUEST["u"])) $userid=$_REQUEST["u"];

	class PDF extends FPDF
		{
// Page header

	 		var $imfil;
			function getimgg()
				{
    			return $this->imfil;
				}
			function setimgg($str)
				{
    			$this->imfil=$str;
				}
			function Header()
				{
   				 // Logo
    			$this->Image($this->imfil,150,25,30);
    			// Arial bold 15
    			$this->SetFont('Arial','B',25);
    			// Move to the right
    			//$this->Cell(80);
    			// Title
   				 $this->Cell(0,10,'Office of the Accountants General, Kerala',1,0,'C');
   				 // Line break
  				  $this->Ln(20);
				}

				// Page footer
				function Footer()
					{
    			// Position at 1.5 cm from bottom
    			$this->SetY(-15);
    			// Arial italic 8
    			$this->SetFont('Arial','I',8);
    			// Page number
    			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
					}
		}
	$basic=0;
	$ta=0;
	$dta=0;
	$da=0;
	$nm="noOne";
   $getmon = array("JAN"=>"January", "FEB"=>"February", "MAR"=>"March",
    	          "APR"=>"April","MAY"=>"May","JUN"=>"June",
    	          "JUL"=>"July","AUG"=>"August",
    	          "SEP"=>"September","OCT"=>"October","NOV"=>"November",
    	          "DEC"=>"December");
	

	$query="select  ps_nm,
					cdr.dmn_dscrptn cadre,
					sec.dmn_dscrptn sect,
					ps_floor lev,
					ps_frst_nm,
					ps_bldng,
					er_da,
					er_bsc_py,
					er_ca,
					er_cca,
					er_hra ,
					licamnt,
					socamnt,
					asocamnt,
					goamnt,
					storeamnt,
					benamnt,
					recamnt,
					nvl(tier1,0) tier1,
					nvl(er_gpf,0) er_gpf,
					er_cggis,
					er_it,
					er_it_srchr,
					er_cghs,
					er_bll_id,
					er_pt,
					er_lcnc_fee,
					nvl(er_ppsp_ttl,0) ppsp,
					nvl(extrec,0) extrec
			from    clms_erng_yrfl,prsnl_infrmtn_systm,estt_dmn_mstr cdr,estt_dmn_mstr sec,
			        (select ex_idn,sum(ex_rcvry_amnt) licamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='ELI' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) licdets,
			         (select ex_idn,sum(ex_rcvry_amnt) socamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='ECR' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) socdets,
			         (select ex_idn,sum(ex_rcvry_amnt) asocamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='EAS' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) asocdets,
			         (select ex_idn,sum(ex_rcvry_amnt) goamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='EMC' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) godets,
			         (select ex_idn,sum(ex_rcvry_amnt) storeamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='ECS' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) storedets,
			         (select ex_idn,sum(ex_rcvry_amnt) benamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='EBF' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) bendets,
			         (select ex_idn,sum(ex_rcvry_amnt) recamnt from clms_extrnl_rcvry_yrfl 
			         where EX_RCVRY_CD='ERC' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) recdets,
			         (select rc_idn,sum(rc_rcvry_amnt) extrec from  clms_rcvry_yrfl
					  where  
					   upper('01-'||to_char(rc_mnth_of_acnt,'mon-yy'))='$mnth'   group by rc_idn) extdets

			where   er_idn='$idno' and  er_idn=ps_idn and ps_sctn_id=sec.dmn_id(+)
			        and ps_cdr_id=cdr.dmn_id(+) and
			        er_idn=licdets.ex_idn(+) and
			        er_idn=socdets.ex_idn(+) and
			        er_idn=asocdets.ex_idn(+) and
			        er_idn=godets.ex_idn(+) and
			        er_idn=storedets.ex_idn(+) and
			        er_idn=bendets.ex_idn(+) and
			        er_idn=recdets.ex_idn(+) and
			        er_idn=extdets.rc_idn(+) and
	                er_mnth_of_acnt='$mnth' ";

	        $query2="select 
					ps_nm,
					cdr.dmn_dscrptn cadre,
					sec.dmn_dscrptn sect,
					ps_floor lev,
					ps_frst_nm,
					ps_bldng,
					er_da,
					er_bsc_py,
					er_ca,
					er_cca,
					er_hra ,
					licamnt,
					socamnt,
					asocamnt,
					goamnt,
					storeamnt,
					benamnt,
					recamnt,
					nvl(tier1,0) tier1,
					nvl(er_gpf,0) er_gpf,
					er_cggis,
					er_it,
					er_it_srchr,
					er_cghs,
					er_bll_id,
					er_pt,
					er_lcnc_fee,
					nvl(er_ppsp_ttl,0) ppsp,
					nvl(extrec,0) extrec
			from    clms_erng_entry,prsnl_infrmtn_systm,estt_dmn_mstr cdr,estt_dmn_mstr sec,
			        (select ex_idn,sum(ex_rcvry_amnt) licamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='ELI' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) licdets,
			         (select ex_idn,sum(ex_rcvry_amnt) socamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='ECR' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) socdets,
			         (select ex_idn,sum(ex_rcvry_amnt) asocamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='EAS' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) asocdets,
			         (select ex_idn,sum(ex_rcvry_amnt) goamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='EMC' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) godets,
			         (select ex_idn,sum(ex_rcvry_amnt) storeamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='ECS' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) storedets,
			         (select ex_idn,sum(ex_rcvry_amnt) benamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='EBF' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) bendets,
			         (select ex_idn,sum(ex_rcvry_amnt) recamnt from clms_extrnl_rcvry_dtls 
			         where EX_RCVRY_CD='ERC' 
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) recdets,
			         (select rc_idn,sum(rc_rcvry_amnt) extrec from  clms_rcvry_entry
					 where  
					 upper('01-'||to_char(rc_mnth_of_acnt,'mon-yy')) like '$mnth'   group by rc_idn) extdets
			where   er_idn='$idno' and  er_idn=ps_idn and ps_sctn_id=sec.dmn_id(+)
			        and ps_cdr_id=cdr.dmn_id(+) and 
			        er_idn=licdets.ex_idn(+) and
			        er_idn=socdets.ex_idn(+) and
			        er_idn=asocdets.ex_idn(+) and
			        er_idn=godets.ex_idn(+) and
			        er_idn=storedets.ex_idn(+) and
			        er_idn=bendets.ex_idn(+) and
			        er_idn=recdets.ex_idn(+) and
			        er_idn=extdets.rc_idn(+) and
	                er_mnth_of_acnt='$mnth' ";

	$query=$query." union ".$query2;
if (!$conn)
		{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
		}
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	$basic=0;
	$ta=0;
	$dta=0;
	$da=0;
	$nm="noOne";
	while($row=oci_fetch_array($statemen))
	{
	$basic=$row["ER_BSC_PY"];
	$ta=$row["ER_CA"];
	$dta=$row["ER_CCA"];
	$da=$row["ER_DA"];
	$hra=$row["ER_HRA"];
	$ppsp=$row["PPSP"];
	$licamnt=$row["LICAMNT"];
	$socamnt=$row["SOCAMNT"];
	$asocamnt=$row["ASOCAMNT"];
    $goamnt=$row["GOAMNT"];
    $storeamnt=$row["STOREAMNT"];
    $benamnt=$row["BENAMNT"];
    $recamnt=$row["RECAMNT"];
    $tier1=$row["TIER1"];
    $gpf=$row["ER_GPF"];
    if($gpf==0) $gpf=$tier1;
    $cggis=$row["ER_CGGIS"];
	$nm=$name;
	

	$pan=$row["PS_BLDNG"];
	$cadre=$row["CADRE"];
	$sect=$row["SECT"];
	$lev=$row["LEV"];
	$kltva=$row["PS_FRST_NM"];

	$it=$row["ER_IT"];
	$itsrchr=$row["ER_IT_SRCHR"];
	$cghs=$row["ER_CGHS"];
	$pt=$row["ER_PT"];
	$lf=$row["ER_LCNC_FEE"];
	$bllid=$row["ER_BLL_ID"];

	$extrec=$row["EXTREC"];

	$stot=$basic+$ta+$dta+$da+$hra+$ppsp;
	$rtot=$licamnt+$socamnt+$asocamnt+$goamnt+$storeamnt+$benamnt+$recamnt;
	$irtot=$cggis+$gpf+$it+$itsrchr+$cghs+$pt+$lf+$extrec;
	$gross=$stot-$rtot-$irtot;

	}
$mnconv=(substr($mnth,3,3));
$yr='20'.(substr($mnth,7,4));
//$mnconv="'$mnconv'";
// Instanciation of inherited class
$pdf = new PDF();
$pdf->setimgg('cag/nop.jpeg');
if (file_exists("photo_cag/$idno.jpg")) $pdf->setimgg("photo_cag/$idno.jpg");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',16);
$pdf->Ln(30);
$pdf->Cell(0,10,"Salary Slip of $nm for the month of $getmon[$mnconv], $yr",'B',1,'C');
$pdf->SetFont('Times','B',12);

$pdf->Cell(30,7,"Bill ID",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(45,7,":$bllid",0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(35,7,"",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,"",0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,7,"",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,"",0,1);
$pdf->SetFont('Times','B',12);

//$pdf->Cell(30,7,"Month",'B',0);
//$pdf->Cell(30,7,":$getmon[$mnconv]",'B',0);
$pdf->Cell(30,7,"Name",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(45,7,":$nm",0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(35,7,"Cadre",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,":$cadre",0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,7,"",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,"",0,1);
$pdf->SetFont('Times','B',12);
//$pdf->SetFont('Times','',12);

$pdf->Cell(30,7,"KLTVA number",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(45,7,":$kltva",0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(35,7,"Level in Paymatrix",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,":$lev",0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,7,"",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,"",0,1);
$pdf->SetFont('Times','B',12);

$pdf->Cell(30,7,"Section",'B',0);
$pdf->SetFont('Times','',12);
$pdf->Cell(45,7,":$sect",'B',0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(35,7,"PAN:",'B',0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,":$pan",'B',0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,7,"",'B',0);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,7,"",'B',1);
$pdf->SetFont('Times','B',12);

$pdf->Cell(30,7,"PAY",'B',0);
$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,"RECOVERY(EXT)",'B',0);
$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,"RECOVERY(INT)",'B',0);
$pdf->Cell(30,7,"",'B',1);
$pdf->SetFont('Times','',12);

$pdf->Cell(30,7,"Basic Pay",0,0);
$pdf->Cell(30,7,":$basic",0,0);
$pdf->Cell(30,7,"LIC Amount",0,0);	
$pdf->Cell(30,7,":$licamnt",0,0);
$pdf->Cell(30,7,"Misc Recoveries",0,0);	
$pdf->Cell(30,7,":$extrec",0,1);

$pdf->Cell(30,7,"DA",0,0);
$pdf->Cell(30,7,":$da",0,0);
$pdf->Cell(30,7,"Credit Society",0,0);
$pdf->Cell(30,7,":$socamnt",0,0);
$pdf->Cell(30,7,"GPF:",0,0);	
$pdf->Cell(30,7,":$gpf",0,1);

$pdf->Cell(30,7,"TA",0,0);
$pdf->Cell(30,7,":$ta",0,0);
$pdf->Cell(30,7,"Association",0,0);
$pdf->Cell(30,7,":$asocamnt",0,0);
$pdf->Cell(30,7,"CGGIS",0,0);	
$pdf->Cell(30,7,":$cggis",0,1);

$pdf->Cell(30,7,"DA on TA",0,0);
$pdf->Cell(30,7,":$dta",0,0);
$pdf->Cell(30,7,"GO society",0,0);
$pdf->Cell(30,7,":$goamnt",0,0);
$pdf->Cell(30,7,"IT",0,0);	
$pdf->Cell(30,7,":$it",0,1);

$pdf->Cell(30,7,"HRA",0,0);
$pdf->Cell(30,7,":$hra",0,0);
$pdf->Cell(30,7,"Store",0,0);
$pdf->Cell(30,7,":$storeamnt",0,0);
$pdf->Cell(30,7,"Edn.Cess",0,0);	
$pdf->Cell(30,7,":$itsrchr",0,1);

$pdf->Cell(30,7,"Special",0,0);
$pdf->Cell(30,7,":$ppsp",0,0);
$pdf->Cell(30,7,"Benov Fund:",0,0);
$pdf->Cell(30,7,":$benamnt",0,0);
$pdf->Cell(30,7,"CGHS",0,0);	
$pdf->Cell(30,7,":$cghs",0,1);

$pdf->Cell(30,7,"",0,0);
$pdf->Cell(30,7,"",0,0);
$pdf->Cell(30,7,"Rec Club",0,0);
$pdf->Cell(30,7,":$recamnt",0,0);
$pdf->Cell(30,7,"Prof Tax",0,0);	
$pdf->Cell(30,7,":$pt",0,1);

$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,"License Fee",'B',0);	
$pdf->Cell(30,7,":$lf",'B',1);


$pdf->Cell(30,7,"Total",'B',0);
$pdf->Cell(30,7,":$stot",'B',0);
$pdf->Cell(30,7,"",'B',0);
$pdf->Cell(30,7,":$rtot",'B',0);
$pdf->Cell(30,7,"",'B',0);	
$pdf->Cell(30,7,":$irtot",'B',1);

$pdf->SetFont('Times','B',12);
$pdf->Cell(60,7,"Net Salary after deductions",'B',0);	
$pdf->Cell(30,7,":$gross",'B',1);

$pdf->SetFont('Times','',8);
$pdf->SetTextColor(255,0,0);
$notif="*Disclaimer:This is only an intimation of pay and allowances";
$discl2="This is not to be used for any other purposes such as";
$discl3="availing loan";

$pdf->Cell(0,3,"",0,1);
$pdf->Cell(0,5,"$notif.$discl2 $discl3",'B',1);
$pdf->Output();

}
}
?>

<head>

<script>
function listmonths()
	{   str=document.getElementById("empname").value;
		//document.getElementById("wing").value=document.getElementById("wing1").value;
		//console.log("this is it"+str);
		if (str.length!=0)
			{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
				{
		if (this.readyState == 4 && this.status == 200)
					{    //console.log('The resposeText received is this '+this.responseText);
		document.getElementById("month").innerHTML=this.responseText;
					}
				};
				
		xmlhttp.open("GET", "getmonths.php?q=" + str, true);
		//console.log(str);
        xmlhttp.send();
			}
	}
</script>

<style>
					
					#titlle
					{
						text-align: center;
						width: 100%;
						left:30%;
					}
					form 
					{
						position: relative;
    				border: 3px solid green;
    				width:30%;
    				left:30%;
    				top:20%;
    				background-color: white;
					}

					/* Full-width inputs */
					.boxes {
    				width: 100%;
    				padding: 12px 20px;
    				margin: 8px 0;
    				display: inline-block;
    				border: 1px solid #ccc;
    				box-sizing: border-box;
    				font-style:  italic;
    				font-size: 20px;
							}

					/* Set a style for all buttons */
					#subut {
    				background-color: #4CAF50;
    				color: white;
    				padding: 14px 20px;
    				margin: 8px 0;
    				border: none;
    				cursor: pointer;
    				width: 100%;
							}

					/* Add a hover effect for buttons */
					#subut:hover {
    				opacity: 0.8;
								}

/* Extra style for the cancel button (red) */
				.cancelbtn {
    					width: auto;
    					padding: 10px 18px;
   						background-color: #f44336;
							}

/* Center the avatar image inside this container */
				.imgcontainer {
   						 text-align: center;
    					 margin: 24px 0 12px 0;
								}
				.purple
				{
					background-color: #e6e6fa;
				}



/* Add padding to containers */
.container {
    padding: 16px;
}

/* The "Forgot password" text */
#month {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    #month {
        display: block;
        float: none;
    }
   
}
#hea2
					{
					text-align: center;
					font-size: 2em;
					float:left;
					width:100%;
                    font-weight: bold;
					}
</style>
<h1 id="hea2" style="width:80%;">Type in your name, select the month and get your payslip</h1>
<a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
</head>

<body class="purple">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 


<strong>Employee Name</strong>		: <input type="text" name="empname" id="empname" class="boxes"
                               list="sectionlist"  size="40">
<datalist id="sectionlist">
<?php
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
$query="select distinct ps_nm from prsnl_infrmtn_systm order by ps_nm";



$statemen=oci_parse($conn,$query);
oci_execute($statemen);
while ($row = oci_fetch_array($statemen))
	{
$nm=$row["PS_NM"];
echo "<option value='$nm'>";
	}
?>
</datalist><br>

<strong>Month</strong>:<select id="month" name="month" onfocus="listmonths()" class="boxes">
          <option value='n' selected>select a month</option>
	  </select>
<input type="submit" name="submit" id="subut" value="Generate payslip" >
<!-- <a href="welcomeuser.php">back to main page</a> -->
</form>
</body>