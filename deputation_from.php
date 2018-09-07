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
	echo "<th>Name,designation</th>";
	echo "<th>Deputation Location</th>";
	echo "<th>Commencement date</th>";
	echo "<th>Date up to which sanctioned</th>";
	echo "</tr>";

	$query    =" select ps_nm||','||cdr.dmn_dscrptn nd,
				 ps_room_no ,
				 b.dmn_dscrptn place,
                 PS_DPTTN_FRM_DT,
                 PS_DPTTN_TO_DT,
                  (PS_DPTTN_TO_DT-trunc(sysdate)) difer,
                 ' ' remarks
                 from   prsnl_infrmtn_systm a,estt_dmn_mstr b,estt_dmn_mstr cdr,estt_dmn_mstr stat 
				 where  cm_clms_flg in ('F10','F12','F04') 
				 and    b.dmn_id(+)=ps_dpttn_place
				 and    cdr.dmn_id(+)=ps_cdr_id 
				 and    stat.dmn_id(+)=cm_clms_flg
                 order by 
                         (PS_DPTTN_TO_DT-trunc(sysdate))";
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while( $row=oci_fetch_array($statemen))
		{
    $nm       =$row["ND"];
    $deptoloc=$row["PLACE"];
    $commdate =$row["PS_DPTTN_FRM_DT"];
    $sancdate =$row["PS_DPTTN_TO_DT"];
    $difer=$row["DIFER"];
    
    //var_dump($sancdate);

    $time = strtotime($sancdate);
    $sancdateConv = date('d/m/y',$time);
    //$sysd=date("d/m/y");
   // $sysd=new DateTime($sysd);
   // $diff=date_diff($sysd,$sancdateConv);

    echo "<tr>";
	echo "<td>$nm</td>";
	echo "<td>$deptoloc</td>";
	echo "<td>$commdate</td>";
	echo "<td>$sancdate</td>";
	echo "<td>$difer</td>";
	echo "</tr>";

		}
	echo '</table>';
	//echo date("d/m/y");
?>
</body>