
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
   $getmon = array("JAN"=>"January", "FEB"=>"February", "MAR"=>"March",
    	          "APR"=>"April","MAY"=>"May","JUN"=>"June",
    	          "JUL"=>"July","AUG"=>"August",
    	          "SEP"=>"September","OCT"=>"October","NOV"=>"November",
    	          "DEC"=>"December");
	

	$query="select 
					er_da,
					er_bsc_py,
					er_ca,
					er_cca,
					er_hra ,
					licamnt,
					socamnt,
					asocamnt,
					goamnt,
					storeamnt
			from    clms_erng_yrfl,
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
			         and upper('01-'||to_char(EX_CRTD_DT,'mon-yy'))='$mnth' group by ex_idn) storedets
			where   er_idn='$idno' and 
			        er_idn=licdets.ex_idn(+) and
			        er_idn=socdets.ex_idn(+) and
			        er_idn=asocdets.ex_idn(+) and
			        er_idn=godets.ex_idn(+) and
			        er_idn=storedets.ex_idn(+) and
	                er_mnth_of_acnt='$mnth' ";
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
	$licamnt=$row["LICAMNT"];
	$socamnt=$row["SOCAMNT"];
	$asocamnt=$row["ASOCAMNT"];
    $goamnt=$row["GOAMNT"];
    $storeamnt=$row["STOREAMNT"];
	$nm=$name;
	$stot=$basic+$ta+$dta+$da+$hra;
	$rtot=$licamnt+$socamnt+$asocamnt+$goamnt+$storeamnt;
	}
$mnconv=(substr($mnth,3,3));
$yr='20'.(substr($mnth,7,4));
//$mnconv="'$mnconv'";
// Instanciation of inherited class
$pdf = new PDF();
$pdf->setimgg('images/logo.png');
if (file_exists("images/$nm.jpg")) $pdf->setimgg('images/$nm.jpg');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',16);
$pdf->Cell(0,10,"Salary Slip of $nm for the month of $getmon[$mnconv], $yr",0,1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Cell(20,7,"PAY",'B',0);
$pdf->Cell(20,7,"",'B',0);
$pdf->Cell(20,7,"RECOVERY(EXT)",'B',0);
$pdf->Cell(20,7,"",'B',1);
$pdf->SetFont('Times','',12);
$pdf->Cell(20,7,"Basic Pay",0,0);
$pdf->Cell(20,7,":$basic",0,0);
$pdf->Cell(20,7,"LIC Amount",0,0);	
$pdf->Cell(20,7,":$licamnt",0,1);
$pdf->Cell(20,7,"DA",0,0);
$pdf->Cell(20,7,":$da",0,0);
$pdf->Cell(20,7,"Credit Society",0,0);
$pdf->Cell(20,7,":$socamnt",0,1);
$pdf->Cell(20,7,"TA",0,0);
$pdf->Cell(20,7,":$ta",0,0);
$pdf->Cell(20,7,"Association",0,0);
$pdf->Cell(20,7,":$asocamnt",0,1);
$pdf->Cell(20,7,"DA on TA",0,0);
$pdf->Cell(20,7,":$dta",0,0);
$pdf->Cell(20,7,"GO society",0,0);
$pdf->Cell(20,7,":$goamnt",0,1);
$pdf->Cell(20,7,"HRA",'B',0);
$pdf->Cell(20,7,":$hra",'B',0);
$pdf->Cell(20,7,"Store",'B',0);
$pdf->Cell(20,7,":$storeamnt",'B',1);
$pdf->Cell(20,7,"Total",'B',0);
$pdf->Cell(20,7,":$stot",'B',0);
$pdf->Cell(20,7,"",'B',0);
$pdf->Cell(20,7,":$rtot",'B',1);

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
</head>

<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 


<f>Employee Name</f>		: <input type="text" name="empname" id="empname" 
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

Month:<select id="month" name="month" onfocus="listmonths()" >
          <option value='n' selected>select a month</option>
	  </select>
<input type="submit" name="submit" value="execute" >
</form>
</body>