<?PHP
	require_once("./include/membersite_config.php");
	if(!$fgmembersite->CheckLogin())
		{
    $fgmembersite->RedirectToURL("login.php");
    exit;
		}
    
    $privarray=array('ag'=>'9023','dag_admin'=>'9022','dag_sgs2'=>'9025','dag_sgs3'=>'9020','dag_lba'=>'9019');

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
	      if ( $row=oci_fetch_array($statemen)) return $row["PS_IDN"];
	 	  return $nm;
	    }

	 function getnmx($nm,$conn)
	    {       
          if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
		
	      $query="select ps_nm from prsnl_infrmtn_systm where ps_idn like '$nm' ";
	      $statemen=oci_parse($conn,$query);
	      oci_execute($statemen);
	      if ( $row=oci_fetch_array($statemen)) return $row["PS_NM"];
	 	  return $nm;
	    }

	 function getcl($conn,$id)
	 	{
	 	if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
		$num=18;
		//echo "num:".$num;
		$query="select nvl(min(cl),18) cl from leaveapplication where idno='$id' and aproved='y'";
	    $statemen=oci_parse($conn,$query);
	    oci_execute($statemen);
	    if ( $row=oci_fetch_array($statemen)) return $row["CL"];
	    return $num;
	 	}

	 	function getel($conn,$id)
	 	{
	 	if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
		$num=0;
		$query="select nvl(max(el),0) el from leaveapplication where idno='$id' and aproved='y'";
	    $statemen=oci_parse($conn,$query);
	    oci_execute($statemen);
	    if ( $row=oci_fetch_array($statemen)) return $row["EL"];
	    return $num;
	 	}

    function stripSearch($str)
    {
    $sstr=str_replace(' ', '', $str);
    return $sstr;
    }

    function test_input($data) 
		{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = htmlentities($data);
	return $data;
		}
    $_SESSION["secdef"]='n';
    $_SESSION["thdef"]='n';
    $_SESSION["fodef"]='n';
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

	$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
  	if (!$conn)
				{echo 'Failed to connect to Oracle';
			     die("Connection failed: " . $conn->connect_error);
				}
	$current_user=$fgmembersite->Userid();
	$usertype=$fgmembersite->Userrole();
	 

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
    		
    		$idpayy=getid($current_user,$conn);
    	    if ($usertype=='basic')
	   		$query="select distinct ps_idn from prsnl_infrmtn_systm where ps_idn='$idpayy' 
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
    		echo "<a href='index.php'><strong>Go Back</strong></a>"."<br>";	
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







<!DOCTYPE html>
<html>
<head>






<!--   CHAT CONTENT -->
<script>
lastReceived=0;



function decidecomm(res)
   {
   	
   	if(res.match(/same_user/g)=='same_user')
   		alert('dont click on your own name');
   	else
   		{
   			if (res=='cleared')
   				inf1.innerHTML='now, everyone can view your messages<br>';
   			else if (res=='')
   				inf1.innerHTML='now, everyone can view your messages<br>';
   			else
   			inf1.innerHTML='now only '+res+' can view your messages<br>';

   	    }
   }

function usersel(recr)
  {
  	var receiver=recr.innerHTML;
  	//recr.style.background-color='green';
  	var sendr=signInName.innerHTML;
  	var data='sender='+sendr+'&'+'receiver='+receiver;

  	Ajax_Send("GET","decidecomm.php",data,decidecomm);

  }

  function unhook()
  {
  	
  	var sendr=signInName.innerHTML;
  	var data='cs='+sendr;
  	Ajax_Send("GET","decidecomm.php",data,decidecomm);

  }
// Sign out response
function checkSignOut(res)
	{
	if(res=="usernotfound")
		{
		serverRes.innerHTML="Sign out error";
		res="signout";
		}
	if(res.match(/signout/g)=="signout")
		{
		hideShow("hide");
		signInForm.userName.focus();
		clearInterval(updateInterval);
		serverRes.innerHTML="Sign out";
		return false;
		}
	}

// Update messages view
function showMessages(res)
	{
	serverRes.innerHTML="";
	msgTmArr=res.split("<SRVTM>");
	lastReceived=msgTmArr[1];
	messages=document.createElement("span");
	messages.innerHTML=msgTmArr[0];
	chatBox.appendChild(messages);
	chatBox.scrollTop=chatBox.scrollHeight;
	}


// update online users
function showUsers(res)
	{
	usersOnLine.innerHTML=res;
	}


// Update info
function updateInfo()
	{
	var sendr=signInName.innerHTML;
	serverRes.innerHTML="Updating";
	Ajax_Send("GET","users.php","",showUsers);
	Ajax_Send("GET","receive.php","lastreceived="+lastReceived+"&sendr="+sendr,showMessages);
	}

// Sent Ok
function sentOk(res)
	{
		//console.log(res);
	if(res.match(/sentok/g)=="sentok")
		{
		messageForm.message.value="";
		messageForm.message.focus();
		serverRes.innerHTML="Sent";
		}
	else{
		serverRes.innerHTML="Not sent";
		}
	}

function sendMessage()
	{
	data="message="+messageForm.message.value+"&user="+signInForm.userName.value;
	//console.log(data);
	serverRes.innerHTML="Sending";
	Ajax_Send("GET","send.php",data,sentOk);
	}

// Sign in response
function checkSignIn(res)
	{
		//res=res.match(/signin/g);
		//console.log(res);
	if(res.match(/userexist/g)=="userexist")
		{
		alert("The user name you typed is already exist\nPlease try another one");
		return false;
		}
	if(res.match(/signin/g)=="signin")
		{
		hideShow("show");
		messageForm.message.focus();
		updateInterval=setInterval("updateInfo()",1000);
		serverRes.innerHTML="Sign in";
		}
	}


// Sign in and Out
function signInOut()
	{
// Validation
	if (signInForm.userName.value=="" || signInForm.userName.value.indexOf(" ")>-1)
		{
		alert("Not valid user name\nPlease make sure your user name didn't contains a space\nOr it's not empty.");
		signInForm.userName.focus();
		return false;
		}
// Sign in
	if (signInForm.signInButt.name=="signIn")
		{
		data="user=" + signInForm.userName.value +"&oper=signin";
		Ajax_Send("GET","users.php",data,checkSignIn);
		return false;
		}

// Sign out
		if (signInForm.signInButt.name=="signOut")
			{
			data="user=" + signInForm.userName.value +"&oper=signout";
			Ajax_Send("GET","users.php",data,checkSignOut);
			return false;
			}
	}



function hideShow(hs)
		{
		if(hs=="hide")
			{
			signInForm.signInButt.value="Sign in";
			signInForm.signInButt.name="signIn";
			messageForm.style.display="none";
			signInForm.userName.style.display="block";
			signInName.innerHTML="";
			}
		if(hs=="show")
			{
			signInForm.signInButt.value="Sign out";
			signInForm.signInButt.name="signOut";
			messageForm.style.display="block";
			signInForm.userName.style.display="none";
			signInName.innerHTML=signInForm.userName.value ;
			}
		}


function Ajax_Send(GP,URL,PARAMETERS,RESPONSEFUNCTION)
	{ 
		URL='chatgyc/'+URL;
		var xmlhttp;
		try {
			 xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
		catch(e)
		      {
               try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
               catch(e){
                        try{xmlhttp=new XMLHttpRequest();}
                        catch(e){
								alert("Your Browser Does Not Support AJAX");
								}
						}
			   }

		err="";
        if (GP==undefined) err="GP ";
        if (URL==undefined) err +="URL ";
        if (PARAMETERS==undefined) err+="PARAMETERS";
        if (err!="") 
        	{alert("Missing Identifier(s)\n\n"+err);
             return false;
            }

		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState == 4){
			if (RESPONSEFUNCTION=="") return false;
			//console.log('hello'+RESPONSEFUNCTION);
			eval(RESPONSEFUNCTION(xmlhttp.responseText))
										}
											 }

			if (GP=="GET")
						{
						URL+="?"+PARAMETERS;
						xmlhttp.open("GET",URL,true);
						xmlhttp.send(null);
						}

			if (GP=="POST")
						{
						PARAMETERS=encodeURI(PARAMETERS);
						xmlhttp.open("POST",URL,true);
						xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.setRequestHeader("Content-length",PARAMETERS.length);
						xmlhttp.setRequestHeader("Connection", "close");
						xmlhttp.send(PARAMETERS);
						}
	}
</script>


<style>
				#signInForm, #messageForm {
				margin:0px;
				margin-bottom:1px;
											}
#userName {
	width: 150px;
	height: 22px;
	border: 1px teal solid;
	float:left;
}
#signInButt {
	width: 60px;
	height: 22px;
}	
#signInName{
	font-family:Tahoma;
	font-size:12px;
	color:orange;
}
#chatBox {
	font-family:tahoma;
	font-size:12px;
	color:black;
	border: 1px teal solid;
	height: 225px;
	width: 400px;
	overflow: scroll;
	float:left;

}
#usersOnLine{
	font-family:tahoma;
	font-size:14;
	color:orange;
	border:1px teal solid;
	width:150px;
	height:225px;
	overflow:scroll;
	margin-left:1px;
}
#message {
	width: 350px;
	height: 22px;
	border: 1px teal solid;
	float:left;
	margin-top:1px;
}
#send {
	width: 50px;
	height: 22px;
	float:left;
	margin:1px;
}
#serverRes{
	width:150px;
	height:22px;
	border: 1px teal solid;
	float:left;
	margin:1px;
}

</style>

<!--   CHAT CONTENT -->



<meta name="viewport" content="width=device-width, initial-scale=1">
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
 									width:25%;
 									}
 								.pplg
 								   {
 								   	width:9%;
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
                				/*font-size: 48px;*/
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





								#titlle
					{
						text-align: center;
						width: 100%;
						left:30%;
					}
					#formslip
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









				* {box-sizing: border-box}

				/* Set height of body and the document to 100% */
				body, html {
    				height: 100%;
    				margin: 0;
    				font-family: Tahoma;
							}

					/* Style tab links */
				.tablink {
    			background-color: #555;
    			color: white;
    			float: left;
    			border: none;
   				outline: none;
    			cursor: pointer;
    			padding: 14px 16px;
    			font-size: 17px;
    			width: 10%;
    			height:10%;
						}

				.tablink:hover {
    			background-color: #777;
								}

				/* Style the tab content (and add height:100% for full page content) */
				.tabcontent {
    						color: black;
    						display: none;
   							/* padding: 100px 20px;*/
    						height: 100%;
							}

							#Home1 {background-color: #ffffcc;}
							#Home2 {background-color: #ffffcc;}
							#Home3 {background-color: #ffffcc;}
							#Home4 {background-color: #ffffcc;}
							#Home5 {background-color: #ffffcc;}
							#Home6 {background-color: #ffffcc;}
							#Home6a {background-color: #ffffcc;}
							#Home6b {background-color: #ffffcc;}
							#Home6c {background-color: #ffffcc;}
							#Home7 {background-color: #ffffcc;}
							#usersOnLine{background-color: white;}
							#chatBox{background-color: white;}

							.dropbtn {
    						/*background-color: #555;
    						color: white;
    						padding: 16px;*/
    						font-size: 16px;
    						border: none;
									}

							
							.dropdown {
    						position: relative;
    						display: inline-block;
    						float:left;
    						width:20%;
									  }

							.dropdown-content {
    						display: none;
    						position: absolute;
    						background-color: #f9f9f9;
    						min-width: 160px;
    						box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    						z-index: 1;
												}

							.dropdown-content button {
    						color: white;
    						font-weight: bold;
    						padding: 12px 16px;
    						text-decoration: none;
    						display: block;
												}


							.dropdown-content button:hover {background-color: #f1f1f1}


							.dropdown:hover .dropdown-content {
    						display: block;
															   }


							.dropdown:hover .dropbtn {
    						background-color: #3e8e41;
													 }

						    .maindbbutton
						    	{
						    background-color: #4CAF50;
    				        color: white;
    				        padding: 14px 20px;
    				        margin-top: none;
    				        border: none;
    				        cursor: pointer;
    				        border:2px solid black;
						    	}
						    .maindbbutton:hover
						        {
						    opacity: 0.5;
						        }
						     .hovop:hover
						        {
						        cursor:pointer;
						        opacity: 0.5;
						        }

						    .ddbutton
						    	{
						    background-color: #4CAF50;
    				        color: white;
    				        width:100%;
    				        border: none;
    				        cursor: pointer;
    				        
						    	}
						    .ddbutton:hover
						        {
						    opacity: 0.5;
						    color:red;
						        }



						    /*Table styles leave*/

						    #ack
				    			{
				    		color:green;
				    		font-size: 1em;
				    		text-align: center;

				    			}
							#hea
								{
							text-align: center;
							font-size: 2.5em;
								}

				.bl
					{
					font-weight: bold;
					}
				table#t01 
					{
    				width: 100%; 
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
					.novis
					{
				    visibility: hidden;
				    width:2px;
					}
    

    			/*leave approver*/

    			.llg
				{
				float:left;
				width:25%;
				}
				.cllg
				{
				float:left;
				width:70%;
				}
				lab
				{
					clear: left;
				}

				#hea2
					{
					text-align: center;
					font-size: 1.5em;
					float:left;
					width:100%;
                    font-weight: bold;
					}




					/*  resetting password*/


					.rlg
						{
						float:left;
						width:50%;
						margin-bottom: 30px;

						}
					.bl
						{
						font-weight: bold;
						}
					.cl
					    {
					     clear:both;
					    }
					.f50
					    {
					    	width:50%;
					    }
					.f100
					    {
					    	width:98%;
					    }
					 .marglef
					 	{
					 		margin-left: 15%;
					 		/*margin-top: 10%;*/

					 	}
					 er
					    {
					 color:red;
					 font-size: 15px;
					 width:100%;
					 text-align: center;
					 float:left;
					    }
					 cor
					    {
					 color:green;
					 font-size: 15px;
					 width:100%;
					 text-align: center;
					 float:left;
					    }

					 .toolmas .tooltex
					 	{
					 visibility: hidden;
					 position: absolute;
					 background-color: black;
    				 color: #fff;
    				 text-align: center;
    				 padding: 5px 0;
    				 border-radius: 6px;
    				 z-index: 1;
					 	}
					 .toolmas:hover .tooltex
					    {
					    	visibility:visible;
					    }
					 .toolmas
					    {
					    position: relative;
    					display: inline-block;

    					}
    				 .abs
    				    {
    				    position: absolute;
    				    }

    				    .midg
						{
						float:left;
						width:25%;
						}


</style>




					<script>

					function dbwenn(d2,d1)
	        		{
	        			var dd2=new Date();
	        			var dd1=new Date();
	        			dd2=d2;
	        			dd1=d1;
                		var oneDay=1000*60*60*24;
	        			return (Math.round(((dd1.getTime() - dd2.getTime())/(oneDay))));
	        		}
		 			function stringToDate(str)
	 				{
    				var date = str.split("/"),
        			d = date[0],
            		m = date[1],
            		y = date[2];
            		//console.log(m+" "+d+" "+y);
           			return (new Date(y + "-" + m + "-" + d));//.toUTCString();
            		}
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
             
                     
					function listmonths()
						{   
						str=document.getElementById("empname").value;
						if (str.length!=0)
							{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function()
									{
									if (this.readyState == 4 && this.status == 200)
										{    
									document.getElementById("month").innerHTML=this.responseText;
										}
									};
						xmlhttp.open("GET", "getmonths.php?q=" + str, true);
		        		xmlhttp.send();
							}
						}

					function openPage(pageName,elmnt,color) 
						{
    				var i, tabcontent, tablinks;
    				tabcontent = document.getElementsByClassName("tabcontent");
    				for (i = 0; i < tabcontent.length; i++) 
    						{
        			tabcontent[i].style.display = "none";
    						}
    				tablinks = document.getElementsByClassName("tablink");
    				for (i = 0; i < tablinks.length; i++) 
    						{
        			tablinks[i].style.backgroundColor = "";
    						}
    				document.getElementById(pageName).style.display = "block";
    				elmnt.style.backgroundColor = color;
						}

	        
					function myfunc()
						{
					alert('done');
						}
            		function altervis(toshow,tohide)
			    		{
			    	var showdoc=document.getElementById(toshow).style;
			    	var hidedoc=document.getElementById(tohide).style;
                	//console.log("entered altervis with toshow="+toshow);
                	//console.log('enterd altervis with tohide='+tohide);
			    	showdoc.position='relative';
			    	showdoc.float='left';
			    	showdoc.visibility='visible';
			    	//showdoc.width=70%;

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

					function vallist(col,elem,opto='no',sellist='n')
						{
							//if (sellist=='y')
								//console.log(' col:'+col+' elem:'+elem);
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function()
						{
						if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
						//if (sellist=='y')
								//console.log(' resptex:'+this.responseText);
					document.getElementById(elem).innerHTML=this.responseText;
							}
						};
					if ((opto!='desc')&&(sellist=='n'))
					xmlhttp.open("GET", "vallist.php?q=" + col, true);
				    else if(sellist=='y')
				    xmlhttp.open("GET", "vallist2.php?q=" + col, true);	
			    	else
			    	xmlhttp.open("GET", "vallist.php?q=" + col+"&b="+'desc', true);
		    	 	xmlhttp.send();
						}

					function clrdets()
						{
					for( var ind in document.getElementsByClassName("inp"))
					document.getElementsByClassName("inp")[ind].value="";
						}

					function allrfilled()
						{
					for( var ind in document.getElementsByClassName("inp"))
						$chqflg=true;
					if((document.getElementsByClassName("inp")[ind].value==""))
						$chqflg=false;
					return $chqflg;
						}

                    function hidetabz()
						{
					document.getElementById("offbutton02").click();
					document.getElementById("offbutton2").click();
					document.getElementById("offbutton22").click();
						}
					function showtabz(tab)
					    {
					if (tab==1)
							{
							hidetabz();
							document.getElementById("offbutton0").click();
							}
					else if (tab==2)
							{
							hidetabz();
							document.getElementById("offbutton").click();
							}
					else
						    {
							hidetabz();
							document.getElementById("offbutton3").click();
							}
					    }
					    function blockandshrink(blo,siz)
					    {
					    	 for( var ind in document.getElementsByClassName("tablink"))
					    	 	if (typeof( document.getElementsByClassName("tablink")[ind].style)!='undefined')
					     document.getElementsByClassName("tablink")[ind].style.width=siz;
					    	document.getElementById(blo).style.display="none";
					    }
					    
					    function fixname(name)
					    {
					    var contentt="<option value='" + name + "'>";
					    //console.log(contentt);
                        document.getElementById("namlist").innerHTML=contentt;
                        document.getElementById("name").value=name;
                        }
	                </script>


	                <!--  ALIEN CONTENT FOR CALENDER ADDED BY KRISHNAMOHAN  -->

	                <link href="outsidecss/jquery.datepick.css" rel="stylesheet">
					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
					<script src="outsidejs/jquery.plugin.min.js"></script>
					<script src="outsidejs/jquery.datepick.js"></script>
					<script>
						$(function() {
						$('#td').datepick({dateFormat:'dd/mm/yyyy'});
						$('#fd').datepick({dateFormat:'dd/mm/yyyy'});
						$('#inlineDatepicker').datepick({onSelect: showDate});
									  });

						function showDate(date) {
									alert('The date chosen is ' + date);
												}
					</script>

                    <!--  ALIEN CONTENT ENDS HERE  -->

	                       
</head>
<body  onbeforeunload="signInForm.signInButt.name='signOut';signInOut()" onload="hideShow('hide')">

<button class=" tablink"  onmouseover="openPage('Home1', this, '#222')" 
        onclick="openPage('Home1', this, 'red')" id="defaultOpen">Employee details
</button>
<button class="tablink" onmouseover="openPage('Home2', this, '#222')" onclick="openPage('Home2', this, 'green')">Reports</button>
<button class="tablink" onmouseover="openPage('Home3', this, '#222')" onclick="openPage('Home3', this, 'blue')">Payslip</button>
<button class="tablink" onmouseover="openPage('Home4', this, '#222')" onclick="openPage('Home4', this, 'orange')">Photos</button>
<button class="tablink" onmouseover="openPage('Home5', this, '#222')" id="secdef" onclick="openPage('Home5', this, 'green')">Approve leave</button>
<button class="tablink" onmouseover="openPage('Home6', this, '#222')" id="thdef" onclick="openPage('Home6', this, 'black')">Apply for leave</button>
<button class="tablink" onmouseover="openPage('Home6a', this, '#222')" id="fivdef" onclick="openPage('Home6a', this, 'black')">ITcomplaint</button>
<button class="tablink" onmouseover="openPage('Home6b', this, '#222')" id="sixdef" onclick="openPage('Home6b', this, 'black')">Address ITcomplaints</button>
<button class="tablink" onmouseover="openPage('Home6c', this, '#222')" id="sevdef" onclick="openPage('Home6c', this, 'black')">Greet your colleagues</button>
<button class="tablink" onmouseover="openPage('Home7', this, '#222')" id="fodef"  onclick="openPage('Home7', this, 'blue')">Reset Password</button>
 <script>

 				<?php
 				//echo "alert('You have logged in with a/an $usertype usertype. Only an all usertype has full access');";
				if ($usertype=='basic')
					{
					echo "blockandshrink('secdef','11.11%');";
				    echo "blockandshrink('sixdef','12.5%');";
				 	}
				?>

 </script>
  
<div id="Home1" class="tabcontent">
 

  <div class="dropdown">
  <button class="dropbtn"> <h3>Employee details</h3></button>
  <div class="dropdown-content">
    <button type="button" id="bx1" class="ddbutton" onclick="showtabz(1)">biodata</button>
    <button type="button" id="bx2" class="ddbutton" onclick="showtabz(2)">Office details</button>
    <button type="button" id="bx3" class="ddbutton" onclick="showtabz(3)">Pay details</button>
  </div>
</div>

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
            $_SESSION["wonw"]=test_input($_POST["wonw"]);

            
					}
					
	 {$go_ahead=1;}	
		
			}
	    else
	    	$go_ahead=1;


	

?>



<form method="post" id="maindbform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  
       onsubmit="if (allrfilled()) return confirm('Did you forget to press the clear button before hitting search? if yes probably you wont get the desired results');" > 
<button type="button" class='maindbbutton' onclick="clrdets()">clear</button>
<input type="submit" name="maindbsub" value="Search" id="maindbsub" 
        class='maindbbutton'> 
 <a href='logout.php' class='hovop'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>




    

    
    
<fieldset id="nameset">
	<legend>Basic Info</legend>
	<t2 class="pplg pmd psm"><f> Name </f></t2>
    <inp class="plg pmd psm">
    :<input type='text'  name="name" id="name" class="inp" list="namlist">
    <datalist id='namlist'></datalist>
        <!--
    <select  name="name" id="name" class="inp">
    <option value='%'>select all</option>
    </select>
    -->
    </inp>

    <t7 class="pplg pmd psm"><f>Office</f></t7>
    <inp class="plg pmd psm">:<input type="text" name="wing" id="wing" list="winglist" 
                      size="40" 
                      onchange="makelistt('%','03','branlist','wing','0')" class="inp"> </inp>   
                      
 
    <datalist id="winglist"></datalist>
     <script>
//vallist('PS_NM','namlist');
    <?php
    if ($usertype=='basic')
    echo "fixname('$current_user');";
    else
    echo  "vallist('PS_NM','namlist');";
    ?>

   // document.getElementById('maindbform').submit();
    </script>
    <!--
    <l2 style="position: relative;width:100%;float:left;clear:left;">
    <t19 class="pplg pmd psm" ><f>Office ID</f></t19>
    <inp class="plg pmd psm">:<input type="text" name="id" id="id" class="inp"></inp>
    </l2>
    -->
    <img src="cag/iii.jpg" id="ima" alt="No Photo" >
</fieldset>



<button type="button" id="offbutton0" class="showswitch" 
         onclick="altervis('bio','offbutton0')">show Bio data</button>
<fieldset id="bio" >

<legend  id="bioo">Bio Data
<button type="button" id="offbutton02" class="hideswitch" 
        onclick="altervis('offbutton0','bio')">show less</button>
</legend>
     
<t1 class="plg pmd psm lab1"><f>Office ID</f></t1>
<inp class="plg pmd psm">:<input type="text" name="id" id="id" class="inp"></inp>

<!--
<t2 class="plg pmd psm"><f> Name </f></t2>
<inp class="plg pmd psm">:<input type="text" name="name" id="name" class="inp"></inp>
-->

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

<addr class="plg pmd psm"><f>Address line1</f></addr>
<inp class="plg pmd psm">:<input type="text" name="addr1" id="addr1" size="40" class="inp"></inp>

<addr class="plg pmd psm"><f>Address line2</f></addr>
<inp class="plg pmd psm">:<input type="text" name="addr2" id="addr2" size="40" class="inp"></inp>

<addr class="plg pmd psm"><f>Address line3</f></addr>
<inp class="plg pmd psm">:<input type="text" name="addr3" id="addr3" size="40" class="inp"></inp>








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

<!--
 <t7 class="plg pmd psm"><f>Wing</f></t7>
 <inp class="plg pmd psm">:<input type="text" name="wing" id="wing" list="winglist" 
                      size="40" 
                      onchange="makelistt('%','03','branlist','wing','0')" class="inp"> </inp>   
                      
 
<datalist id="winglist"></datalist>
-->
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
<inp class="plg pmd psm">:<input type="text" name="wonw" id="wonw" class="inp" list="estatlist"></inp>


<datalist id="estatlist">
	<option value='Working'> <option value='Not Working'>
</datalist>


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
<inp class="plg pmd psm">:<input type="text" name="depplace" id="depplace" class="inp" size="40" ></inp>

<t43 class="plg pmd psm"><f>Deputation Designation</f></t43>
<inp class="plg pmd psm">:<input type="text" name="depdes" id="depdes" class="inp" size="40" ></inp>

<t43 class="plg pmd psm"><f>Deputation From</f></t43>
<inp class="plg pmd psm">:<input type="text" name="dfp" id="dfp" class="inp" size="40" ></inp>


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



<script>

hidetabz();

</script>



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
				$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
			 if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('name',$_POST)))
		     	$name=$_SESSION["z"];
		     else
		     {
		     	$temp_var=$current_user;
		     	if (array_key_exists($temp_var,$privarray)) $temp_var=$privarray[$temp_var];
		     	$name=getnmx($temp_var,$conn);
		     	
		     }

     		 $servername = "localhost/test2";
			 $username = "km";
			 $password = "rt";
			 $dbname="myDB";
			 //$conn = new mysqli($servername, $username, $password,$dbname);
			 //$conn=oci_connect($username,$password,$servername);
			// $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
			 
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
	        //if  ($row["IDNO"]=='basic') $ids=$current_user;
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
	        $searchcrt='';
		if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('name',$_POST)))
		{
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

	        $id2search=$_SESSION["wonw"];
	        //$id2search=$id2search."%";
	        switch($id2search)
	        	{
	        	case "Working":
	        		$id2search='W';
	        		break;
	        	case "Not Working":
	        		$id2search='N';
	        		break;
	        	
	        	}
	       // echo "<script>alert('".  $id2search."')</script>";
	       $id2search=strtolower($id2search);
	        $searchcrt.=" and nvl(lower(PS_FLG),'%') like nvl('$id2search','$noval') ";
		}	
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
  			                 decode(nvl(CM_ACCMMDTN,'No'),'No','No','Govt Quarters') CM_ACCMMDTN,
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
						like '".strtolower($name)."%'".$searchcrt.$subquery
						."order by ps_cdr_id desc";
						   
			 
						   
						   
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
			//echo '<f id="bl"><b>'.$num.' records where found that matches your search string</b></f>';
			echo "<marquee scrolldelay='50' scrollamount='10' truespeed  style='background-color:black;font-size: 36;color:white;font-weight: bold;'  >";
			echo  "WELCOME ".strtoupper(getnmx($current_user,$conn));
			echo "</marquee>";
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
                         //echo 'document.getElementById("ima").src=\'images/'.'2190'.'\.jpg\'';
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

						 echo '<script>';
						 echo 'document.getElementById("net").value=\''.$er_nt_py.'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("it").value=\''.$er_it.'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("itsur").value=\''.$er_it_srchr.'\'';
						 echo '</script>';
						 
						 echo '<script>';
						 echo 'document.getElementById("tr").value=\''.$er_rcvry_ttl.'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("pt").value=\''.$er_pt.'\'';
						 echo '</script>';

						 echo '<script>';
						 echo 'document.getElementById("licence").value=\''.$er_lcnc_fee.'\'';
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

function test_input2($data) 
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

</div>

<div id="Home2" class="tabcontent">
  <hea2 id="hea2" style="width:80%;">Various Reports for administrative uses</hea2>
  <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
  <fieldset>
 <legend>  Reports </legend>

<!--  DROP DOWN NEW                              -->

 <div class="dropdown" style="float:left;width:30%;">
  <button class="dropbtn"> Important Reports   </button>
  <div class="dropdown-content" style="margin-left:130px">
  <pre>
    <a href="employeefulllist.php">All Employee details</a>
 	<a href="staff2hq.php">Staff Position</a>
 	<a href="eventreader.php">Important Events</a>
 	<a href="section_history.php">Section History</a>
 	<a href="retirement.php">Employees due for retirement</a>  
 	<a href="sraos.php">Senior AOs /AOs reporting under each group officer</a>
 	<a href="hqfieldanalydets.php"> HQ Field Analysis (detail)</a>
 	<a href="malefemale.php"> Male/Female count </a>
 	<a href="catcount.php"> Category wise count </a>
 	<a href="promdets.php"> Promotion Details </a>
 	<a href="leavemonitor.php">  Leave Details of Probationers </a>
 	<a href="leavemonitor_cadrewise.php">  Leave Details of Probationers, cadrewise </a>
 	</pre>
  </div>
</div>

 <div class="dropdown" style="float:left;width:30%;">
  <button class="dropbtn"> Staff Position Reports  </button>
  <div class="dropdown-content" style="margin-left:130px">
  <pre>
    <a href="employeefulllist.php">All Employee details</a>
 	<a href="staff2hq.php">Staff Position</a>
 	<a href='countorarepo_v3.php'>Employee Count</a>
 	<a href="staff_position_ersa.php">Staff Position Status in ERSA</a>
 	<a href="staff_position_pdc.php">Staff Position Status in PDC</a>
 	<a href="counter.php">User Specified Report for employee count</a>
 	<a href="detailer.php">User Specified Report for employee details</a>
 	<a href="sraos.php">Senior AOs /AOs reporting under each group officer</a>
 	<a href="sraoscount.php"> No of Senior AOs /AOs reporting under each group officer</a>
 	<a href="hqfieldanaly.php"> HQ Field Analysis (count)</a>
 	<a href="hqfieldanalydets.php"> HQ Field Analysis (detail)</a>
 	<a href="malefemale.php"> Male/Female count </a>
 	<a href="catcount.php"> Category wise count </a>
 	</pre>
  </div>
</div>

 <div class="dropdown" style="float:left;width:30%;">
  <button class="dropbtn"> Reports pertaining to Employee Count  </button>
  <div class="dropdown-content"  style="margin-left:100px">
  <pre>
    <a href="employeefulllist.php">All Employee details</a>
 	<a href='countorarepo_v3.php'>Employee Count</a>
 	<a href="counter.php">User Specified Report for employee count</a>
 	<a href="sraoscount.php"> No of Senior AOs /AOs reporting under each group officer</a>
 	<a href="hqfieldanaly.php"> HQ Field Analysis (count)</a>
 	<a href="malefemale.php"> Male/Female count </a>
 	<a href="catcount.php"> Category wise count </a>
 	</pre>
  </div>
</div>

 <div class="dropdown" style="float:left;width:30%;">
  <button class="dropbtn"> Deputation Reports  </button>
  <div class="dropdown-content">
  <pre>    
 	<a href="deputFROM.php">Persons who are on deputation from this office</a>
 	<a href="deputTO.php">Persons who are on deputation in this office</a>
 	<a href="combinedcadres.php">Staff Position cadre group wise including deputation</a>
 	</pre>
  </div>
</div>

 <div class="dropdown" style="float:left;width:30%;">
  <button class="dropbtn"> Misc Reports  </button>
  <div class="dropdown-content">
  <pre>
   
 	<a href="eventreader.php">Important Events</a>
 	<a href="section_history.php">Section History</a>
 	<a href="retirement.php">Employees due for retirement</a>  
 	<a href="joiningwise.php">Employees who joined between specific dates</a> 
 	<a href="malefemale.php"> Male/Female count </a>
 	<a href="catcount.php"> Category wise count </a>
 	</pre>
  </div>
</div>

 <div class="dropdown" style="float:left;width:30%;">
  <button class="dropbtn"> All Reports  </button>
  <div class="dropdown-content">
  <pre>
    <a href="employeefulllist.php">All Employee details</a>
 	<a href="staff2hq.php">Staff Position</a>
 	<a href="deputFROM.php">Persons who are on deputation from this office</a>
 	<a href="deputTO.php">Persons who are on deputation in this office</a>
 	<a href="eventreader.php">Important Events</a>
 	<a href="section_history.php">Section History</a>
 	<a href='countorarepo_v3.php'>Employee Count</a>
 	<a href="combinedcadres.php">Staff Position cadre group wise including deputation</a>
 	<a href="combinedcadres_nodepo.php">Staff Position cadre group wise excluding deputation</a>
 	<a href="staff_position.php">Staff Position Status in GSSA</a>
 	<a href="staff_position_ersa.php">Staff Position Status in ERSA</a>
 	<a href="staff_position_pdc.php">Staff Position Status in PDC</a>
 	<a href="retirement.php">Employees due for retirement</a>  
 	<a href="joiningwise.php">Employees who joined between specific dates</a> 
 	<a href="counter.php">User Specified Report for employee count</a>
 	<a href="detailer.php">User Specified Report for employee details</a>
 	<a href="sraos.php">Senior AOs /AOs reporting under each group officer</a>
 	<a href="sraoscount.php"> No of Senior AOs /AOs reporting under each group officer</a>
 	<a href="hqfieldanaly.php"> HQ Field Analysis (count)</a>
 	<a href="hqfieldanalydets.php"> HQ Field Analysis (detail)</a>
 	<a href="malefemale.php"> Male/Female count </a>
 	<a href="catcount.php"> Category wise count </a>
 	<a href="promdets.php"> Promotion Details </a>
 	<a href="leavemonitor.php">  Leave Details of Probationers </a>
 	<a href="leavemonitor_cadrewise.php">  Leave Details of Probationers, cadrewise </a>
 	</pre>
  </div>
</div>

 	
 </fieldset>
</div>

<div id="Home3" class="tabcontent">
  <bl id="hea2" class="bl" style="width:80%;">Generate Pay slip</bl>
   <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
  <form method="post" id='formslip' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 


<strong>Employee Name</strong>		: <input type="text" name="empname" id="empname" class="boxes"
                               list="payylist"  size="40">
<datalist id="payylist">
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
<input type="submit" name="subut" id="subut" value="Generate payslip" >

</form>
</div>



<div id="Home4" class="tabcontent">
  <hea id="hea2" style="width:90%;">Link to various photos</hea>
   <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
  <fieldset id="container1">
	<legend> Index</legend>
	<pre>
	<b1 ><a href="photoviewer.php?m=1&r=0">Recreation Club Function 2017 Novembor</a></b1>
	<b1 ><a href="photoviewer.php?m=1&r=1">Hindi Fortnight 2017</a></b1>
	<b1 ><a href="photoviewer.php?m=1&r=2">Independence day 2017</a></b1>
	<b1 ><a href="photoviewer.php?m=1&r=3">Hindi Magazine meeting</a></b1>
	<b1 ><a href="photoviewer.php?m=1&r=4">KIMS</a></b1>
	</pre>
</fieldset>
</div>




<div id="Home5" class="tabcontent">
<hea id="hea2" style="width:90%;">leave approver</hea>
 <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('apy0',$_POST)))
		{echo "<button type='button' id='ack' onclick='hidee()'>approvals/denials confirmed, 
	           click here to hide notification</button>";
	     $_SESSION["secdef"]='y';//session variable to keep this tab alive when the page reloads
		$cn=0;
		while(array_key_exists("apy$cn",$_POST))
			{
		
		$pid=$_POST["idinp$cn"];
		$pfid=$_POST["fdinp$cn"];
		$ptid=$_POST["tdinp$cn"];
		$papy=$_POST["apy$cn"];


        $elleave2=0;
        $clleave2=0;
        $leavetyp2=$_POST["typinp$cn"];
        $days2=$_POST["daysinp$cn"];
		$clleave2=$_POST["clleaveinp$cn"];
		$elleave2=$_POST["elleaveinp$cn"];


		//$papn=$_POST["apn$cn"];
        $apr=$papy;
        if($apr=='y')
        {
        if (($leavetyp2=='CL')&&(($clleave2-$days2)>=0)) $clleave2-=$days2;
        else if ($leavetyp2=='CL') $apr='n';
        if ($leavetyp2=='EL') $elleave2+=$days2;   
        
        }
        else
        {

        if ($leavetyp2=='CL') $clleave2+=$days2;
        if ($leavetyp2=='EL') $elleave2-=$days2;	
        }
        //check if already approved
        $query="select aproved from leaveapplication where 
		        idno='$pid' and
		        todate='$ptid' and
		        fromdate='$pfid' ";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);
		$prevaprove='none';
		while( $row=oci_fetch_array($statemen))
		{
         $prevaprove=$row["APROVED"];
		}
       
         //only if there are changes in approval
        if ($prevaprove!=$apr)
        {
		$query="update leaveapplication set  aproved='$apr',cl=$clleave2,el=$elleave2
		        where 
		        idno='$pid' and
		        todate='$ptid' and
		        fromdate='$pfid' ";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);

		$query="update leaveapplication set  cl=$clleave2,el=$elleave2
		        where 
		        idno='$pid'  ";
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
<th><b1 class="bl"> ID Number</b1></th>
<th><b1 class="bl"> Name</b1></th>
<th><b1 class="bl"> From Date</b1></th>
<th><b1 class="bl"> To Date</b1></th>
<th><b1 class="bl"> Number of Days</b1></th>
<th><b1 class="bl"> Leave Type</b1></th>
<th><b1 class="bl"> CL remaining</b1></th>
<th><b1 class="bl"> EL taken</b1></th>
<th><b1 class="bl"> Approved?</b1></th>
</tr>

<?php

$query="select idno,ps_nm,fromdate fd,todate td,aproved,days,typ,nvl(el,0) el,nvl(cl,0) cl
        from leaveapplication,prsnl_infrmtn_systm where ps_idn=idno";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$count=0;
while( $row=oci_fetch_array($statemen))
		{
$idno=$row["IDNO"];
$nm=$row["PS_NM"];
$fd=$row["FD"];
$td=$row["TD"];
$ap=$row["APROVED"];
$days=$row["DAYS"];
$typ=$row["TYP"];
$elleave=$row["EL"];//29Jan
$clleave=$row["CL"];//29Jan
$chn="checked";
$chy="";
if($ap=='y') 
	{
	$chy="checked";
	$chn="";
	}

echo "<tr>";

echo "<td><inp id='id$count' name='id$count'> $idno</inp>";
echo "<input id='idinp$count' name='idinp$count' class='novis' type='text' value='$idno'></td>";

echo "<td><inp id='nm$count' name='nm$count'> $nm</inp>";
echo "<input id='nminp$count' name='nminp$count' type='text' class='novis' value='$nm'></td>";

echo "<td><inp id='fd$count' name='fd$count'> $fd</inp>";
echo "<input id='fdinp$count' name='fdinp$count' type='text' class='novis' value='$fd'></td>";

echo "<td><inp id='td$count' name='td$count'> $td</inp>";
echo "<input id='tdinp$count' name='tdinp$count' type='text' class='novis' value='$td'></td>";

echo "<td><inp id='days$count' name='days$count'> $days</inp>";
echo "<input id='daysinp$count' name='daysinp$count' type='text' class='novis' value='$days'></td>";

echo "<td><inp id='typ$count' name='typ$count'> $typ</inp>";
echo "<input id='typinp$count' name='typinp$count' type='text' class='novis' value='$typ'></td>";

echo "<td><inp id='clleave$count' name='clleave$count'> $clleave  </inp>";
echo "<input id='clleaveinp$count' name='clleaveinp$count' type='text' class='novis' value='$clleave'></td>";

echo "<td><inp id='elleave$count' name='elleave$count'> $elleave</inp>";
echo "<input id='elleaveinp$count' name='elleaveinp$count' type='text' class='novis' value='$elleave'></td>";

echo "<td>yes<input type='radio' id='apy$count' name='apy$count' value='y' $chy>";
echo "no<input type='radio' id='apn$count' name='apy$count' value='n' $chn></td>";
echo "</tr>";
$count+=1;
		}
?>
</table>


<input type="submit" name="subut2" id="subut2" value="confirm approval/denial" >
</form>
<ul>

<li id="leaveerror"><warn>*CL limit exceeded</warn></li>
</ul>




</div>

<div id="Home6" class="tabcontent">

<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('td',$_POST)))
	{

$td="0";
$fd="0";
$_SESSION["thdef"]='y';


$td=test_input($_POST["td"]);
$fd=test_input($_POST["fd"]);
if (($td=="")||($fd==""))
		{
	//echo "<warn>DATES CANT BE EMPTY</warn>";
	echo "<button type='button' id='ack' onclick='hidee()'>Please enter dates, click to hide</button>";
	//die("DATES CANT BE EMPTY");
		}
		else
		{
$td=get_date($td);
$fd=get_date($fd);
//echo 'tds='.$td;
$days=test_input($_POST["days"]);
$ty=test_input($_POST["ty"]);
if ($days>0)
			{

$idleave=getid($current_user,$conn);
$clremaining=getcl($conn,$idleave);
$eltaken=getel($conn,$idleave);
$decis='n';

$query="insert into leaveapplication (idno,fromdate,todate,days,typ,cl,el,aproved) 
        values (:idno,:fromdate,:todate,:days,:typ,:cl,:el,:aproved) ";
$statemen=oci_parse($conn,$query);

//echo $idleave;
oci_bind_by_name($statemen, ':idno', $idleave);
oci_bind_by_name($statemen, ':fromdate', $fd);
oci_bind_by_name($statemen, ':todate', $td);
oci_bind_by_name($statemen, ':days', $days);
oci_bind_by_name($statemen, ':typ', $ty);
oci_bind_by_name($statemen, ':cl', $clremaining);
oci_bind_by_name($statemen, ':el', $eltaken);
oci_bind_by_name($statemen, ':aproved', $decis);
//oci_bind_by_name($statemen, ':idno', $current_user);
oci_execute($statemen);
			}
			else
				echo "<button type='button' id='ack' onclick='hidee()'>check the dates entered,click to hide 
			           notification
			          </button>";
      }
	}
?>

<b2 id="hea2" style="width:90%;">Pending leave applications</b2>
 <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
<table id="t01">
<tr>
<th><b1 class="bl"> ID Number</b1></th>
<th><b1 class="bl"> Name</b1></th>
<th><b1 class="bl"> From Date</b1></th>
<th><b1 class="bl"> To Date</b1></th>
<th><b1 class="bl"> Number of Days</b1></th>
<th><b1 class="bl"> Leave Type</b1></th>
<th><b1 class="bl"> Approved?</b1></th>
</tr>

<?php
$idleave2=getid($current_user,$conn);
$query="select idno,ps_nm,fromdate fd,todate td,aproved,days,typ from leaveapplication,prsnl_infrmtn_systm 
        where ps_idn=idno and ps_idn='$idleave2'";
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$count=0;
while( $row=oci_fetch_array($statemen))
		{
$idno=$row["IDNO"];
$nm=$row["PS_NM"];
$fd=$row["FD"];
$td=$row["TD"];
$ap=$row["APROVED"];
$days=$row["DAYS"];
$typ=$row["TYP"];
$chn="checked";
$chy="";
if($ap=='y') 
	{
	$chy="checked";
	$chn="";
	}

echo "<tr>";

echo "<td><inp id='id$count' name='id$count'> $idno</inp>";
echo "<input id='idinp$count' name='idinp$count' class='novis' type='text' value='$idno'></td>";

echo "<td><inp id='nm$count' name='nm$count'> $nm</inp>";
echo "<input id='nminp$count' name='nminp$count' type='text' class='novis' value='$nm'></td>";

echo "<td><inp id='fd$count' name='fd$count'> $fd</inp>";
echo "<input id='fdinp$count' name='fdinp$count' type='text' class='novis' value='$fd'></td>";

echo "<td><inp id='td$count' name='td$count'> $td</inp>";
echo "<input id='tdinp$count' name='tdinp$count' type='text' class='novis' value='$td'></td>";

echo "<td><inp id='days$count' name='days$count'> $days</inp>";
echo "<input id='daysinp$count' name='daysinp$count' type='text' class='novis' value='$days'></td>";

echo "<td><inp id='typ$count' name='typ$count'> $typ</inp>";
echo "<input id='typinp$count' name='typinp$count' type='text' class='novis' value='$typ'></td>";

echo "<td>yes<input type='radio' id='apy$count' name='apy$count' value='y' $chy>";
echo "no<input type='radio' id='apn$count' name='apy$count' value='n' $chn></td>";
echo "</tr>";
$count+=1;
		}
?>
</table>



<b3 id="hea2">New leave application</b3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset>
	<legend>Enter details</legend>
	<lab class="llg bl">From</lab><inp class="llg">
	:<input type="text" id="fd" name="fd" placeholder="dd/mm/yyyy" 
	   value='<?php echo $fgmembersite->SafeDisplay('fd') ?>'
	  ></inp>
	<lab class="llg bl">To</lab><inp class="llg">:
	<input type="text" id="td" name="td" placeholder="dd/mm/yyyy"
	value='<?php echo $fgmembersite->SafeDisplay('td') ?>'
	></inp>
	<lab class="llg bl">No of days</lab><inp class="llg" >:
	<input type="text" id="days" name="days"
	   placeholder="num?" onfocus="countdsays()"
	   value='<?php echo $fgmembersite->SafeDisplay('days') ?>'
	></inp>	
	 <lab class="llg bl">Leave Type</lab><inp class="llg">:
	 <select id="ty" name="ty"  >
     <option value='CL' selected>Casual Leave</option>
     <option value='EL' >Earned Leave</option>
     </select>
	 </inp>
</fieldset>
<input type="submit" name="subut2" id="subut2" value="Enter" >
</form>

</div>

<div id="Home6a" class="tabcontent">
<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('comp',$_POST)))
	{

     $_SESSION["sixdef"]='y';
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

<b2 id="hea2" style="width:90%;">Pending Complaints</b2>
 <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
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
	<inp class="cllg">
	:<input type="text" id="comp" name="comp"  size="80"
	   value='<?php echo $fgmembersite->SafeDisplay('comp') ?>'
	  >
	 </inp>

	 <lab class="midg bl">Where?</lab>
	<inp class="cllg">
	:<input type="text" id="cloc" name="cloc"  size="80"
	   value='<?php echo $fgmembersite->SafeDisplay('cloc') ?>'
	  >
	 </inp>
	
</fieldset>
<input type="submit" name="subut3" id="subut3" value="Log" >
</form>

</div>

<div id="Home6b" class="tabcontent">
<hea id="hea2" style="width:90%;">Address and Solve IT complaints</hea>
 <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('apyca0',$_POST)))
		{echo "<button type='button' id='ack' onclick='hidee()'>approvals/denials confirmed, 
	           click here to hide notification</button>";
	    // $_SESSION["secdef"]='y';//session variable to keep this tab alive when the page reloads
		$cn=0;
		$_SESSION["sixdef"]='y';
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
</div>

<div id="Home6c" class="tabcontent">

<bc onbeforeunload="signInForm.signInButt.name='signOut';signInOut()" onload="hideShow('hide')">


<chat1 id='hea2' style="width:90%;"> Greet your colleagues</chat1>
 <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
<infuser id='inf1'></infuser>
<form id="signInForm" onsubmit="signInOut();return false">
	<input id="userName" type="text">

	<input id="signInButt" name="signIn" type="submit" value="Sign in">
	<span id="signInName">Type your name here and start chatting</span>
</form>

<div id="chatBox"></div>

<div id="usersOnLine"></div>

<form id="messageForm" onsubmit="sendMessage();return false">
	<input id="message" type="text">
	<input id="send" type="submit" value="Send">
<div id="serverRes"></div>
</form>
</bc>


</div>

<div id="Home7" class="tabcontent">


<form method="post"  class="marglef" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <a href='logout.php'> <f><img src='images\logoutt.jpg' alt='logout' style="width:111px;height:48px;float:right;"></f></a>
<fieldset class="f50 ">
<legend class="bl">Change your password here</legend>
<lab class="rlg">old password</lab><ent class="rlg">:<input type="text" id="oldpass" name="oldpass" class="f100"></ent>
<lab class="rlg">new password</lab><ent class="rlg">:<input type="text" id="newpass" name="newpass" class="f100"></ent>
<lab class="rlg">hint to remember password</lab><ent class="rlg">:<input type="text" id="hint" name="hint" class="f100">
</ent>
</fieldset>
<input type="submit" name="subut3" value="Change"> 
</form>


<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") && (array_key_exists("oldpass", $_POST)))
			{

				$_SESSION["fodef"]='y';
$idres=getid($current_user,$conn);
$query="select usr_id,pass from admin_user where usr_id='$current_user'";
//echo $query;
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
$psys='fff';
if( $row=oci_fetch_array($statemen))
				{
			$psys=$row["PASS"];
				}
				//echo $psys;
$puser=test_input($_POST["oldpass"]);
$npuser=test_input($_POST["newpass"]);
$hint=test_input($_POST["hint"]);
//echo "old:".$_POST["oldpass"]."new:".$_POST["newpass"];
if (stripSearch($npuser)=="")
    echo "<er>New password cant be empty</er>";
elseif ($puser!=$psys)
   echo "<er>Your old password is incorrect</er>";
else
	            {
	$query="update admin_user set pass='$npuser' where usr_id='$current_user'";
	$statemen=oci_parse($conn,$query);
    oci_execute($statemen);

    $query="update pwordhints set hint='$hint' where usr_id='$current_user'";
	$statemen=oci_parse($conn,$query);
    oci_execute($statemen);
    echo "<cor>Password Changed</cor>";
	            }
			}


?>
<div class="toolmas">

<p><a href='index.php'> <f >Main Page</f></a></p>
            <span class="tooltex">go back</span>
</div>


</div>




<script>
/*
function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;

}*/
// Get the element with id="defaultOpen" and click on it
<?php
if (isset($_SESSION["secdef"])&&($_SESSION["secdef"]=='y') )
echo "document.getElementById('secdef').click();";
else if (isset($_SESSION["thdef"])&&($_SESSION["thdef"]=='y') )
	echo "document.getElementById('thdef').click();";
else if (isset($_SESSION["fodef"])&&($_SESSION["fodef"]=='y') )
	echo "document.getElementById('fodef').click();";
else if (isset($_SESSION["fivdef"])&&($_SESSION["fivdef"]=='y') )
	echo "document.getElementById('fivdef').click();";
else if (isset($_SESSION["sixdef"])&&($_SESSION["sixdef"]=='y') )
	echo "document.getElementById('sixdef').click();";
else
echo "document.getElementById('defaultOpen').click();";
?>
</script>
     
</body>
</html> 