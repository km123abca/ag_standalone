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
<style>
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

</style>
</head>


<body>
<?php
	echo "<table id='t01'>";

	echo "<tr>";
	echo "<th>Name</th>";
	echo "<th>Deputation Location</th>";
	echo "<th>Commencement date</th>";
	echo "<th>Date up to which sanctioned</th>";
	echo "</tr>";

	$query    ="select d.ps_nm,frr.dmn_dscrptn depfrom,too.dmn_dscrptn depto,a.ps_comm_date,a.ps_sanc_date,a.ps_to_frm
	            from deputation_ags a,estt_dmn_mstr too,estt_dmn_mstr frr,prsnl_infrmtn_systm d
	            where a.ps_dpttn_place=too.dmn_id(+)
	            and   a.ps_dpttn_fr_place=frr.dmn_id(+) and d.ps_idn=idno and a.ps_to_frm='f'";
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while( $row=oci_fetch_array($statemen))
		{
    $nm       =$row["PS_NM"];
    $depfroloc=$row["DEPFROM"];
    $deptoloc =$row["DEPTO"];
    $commdate =$row["PS_COMM_DATE"];
    $sancdate =$row["PS_SANC_DATE"];
    $tf       =$row["PS_TO_FRM"];
    //var_dump($sancdate);

    $time = strtotime($sancdate);
    $sancdateConv = date('d/m/y',$time);
    $sysd=date("d/m/y");
    $sysd=new DateTime($sysd);
    $diff=date_diff($sysd,$sancdateConv);

    echo "<tr>";
	echo "<td>$nm</td>";
	echo "<td>$deptoloc</td>";
	echo "<td>$commdate</td>";
	echo "<td>$sancdate</td>";
	echo "</tr>";

		}
	echo '</table>';
	//echo date("d/m/y");
?>
</body>