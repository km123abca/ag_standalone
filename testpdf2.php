
<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>

<?php
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
    $this->Image('images/logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'PaySlip',1,0,'C');
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

$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );

$query="select er_da,er_bsc_py,er_ca,er_cca from clms_erng_yrfl where er_idn='$userid' and rownum<2";
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
	$nm=$userid;
	}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->setimgg('images/logo.png');
if (file_exists("images/$nm.jpg")) $pdf->setimgg('images/$nm.jpg');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,"Name=$nm    ",0,1);
$pdf->Cell(0,10,"basic=$basic   da=$da ",0,1);
$pdf->Cell(0,10,"TA=$ta   DAonTA=$dta",0,1);
/*
for($i=1;$i<=40;$i++)
    {$pdf->Cell(0,10,'Printing line number '.$i,0,1);
     $pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
     }
     */
$pdf->Output();
?>