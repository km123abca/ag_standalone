<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>
<?php
   //require_once("./staff_position.php");
   $wing=$_REQUEST["r"];
   $query="select cd,dmn_dscrptn cadre,c1 tvm,c2 tcr,c3 ekm,c4 ktm,c5 kde,c6 total 
            from
            (select distinct ps_cdr_id cd from prsnl_infrmtn_systm ) aa,

            (select ps_cdr_id cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where 
                    ps_room_no='TVM' and ps_wing='$wing' AND   ps_flg='W'
                    group by ps_cdr_id)a,

			(select ps_cdr_id cd2,count(ps_cdr_id) c2 
					from prsnl_infrmtn_systm where 
 					ps_room_no='TCR' and ps_wing='$wing' AND   ps_flg='W'
					group by ps_cdr_id) b,

			(select ps_cdr_id cd3,count(ps_cdr_id) c3 
					from prsnl_infrmtn_systm where 
 					ps_room_no='EKM' and ps_wing='$wing' AND   ps_flg='W'
					group by ps_cdr_id) c, 

			(select ps_cdr_id cd4,count(ps_cdr_id)  c4
					from prsnl_infrmtn_systm where 
 					ps_room_no='KTM' and ps_wing='$wing' AND   ps_flg='W'
					group by ps_cdr_id) d,
			(select ps_cdr_id cd5,count(ps_cdr_id) c5 
					from prsnl_infrmtn_systm where 
 					ps_room_no='KDE' and ps_wing='$wing' AND   ps_flg='W'
					group by ps_cdr_id) e,

			(select ps_cdr_id cd6,count(ps_cdr_id) c6 
					from prsnl_infrmtn_systm where 
 					ps_wing='$wing' AND   ps_flg='W'
					group by ps_cdr_id) f,

			estt_dmn_mstr 

		where dmn_id(+)=cd and
              cd=cd1(+) and 
              cd=cd2(+) and 
              cd=cd3(+) and 
              cd=cd4(+) and
			  cd=cd5(+) and
			  cd=cd6(+)";
	
	
	
	$order_by_param="nvl(".$_REQUEST["q"].",0)";
	$query.=" order by ".$order_by_param." ".$_SESSION['toggle'];
	if ($_SESSION['toggle']!='desc') $_SESSION['toggle']='desc';
	else $_SESSION['toggle']='';
	$respo="";
	
	//$conn=oci_connect("km","rt","localhost/test2");
	$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	if (!$conn)
		{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
		}
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while( $row=oci_fetch_array($statemen))
 	{
 $cadre=$row["CADRE"];
 $tvmcount=$row["TVM"];
 $tcrcount=$row["TCR"];
 $ekmcount=$row["EKM"];
 $ktycount=$row["KTM"];
 $kdecount=$row["KDE"];
 $sum=$row["TOTAL"];
 $respo.= "<tr> 
       <td>$cadre</td> 
       <td>$tvmcount</td>
       <td>$tcrcount</td> 
       <td>$ekmcount</td>
       <td>$ktycount</td>  
       <td>$kdecount</td>
       <td>$sum</td> 
        </tr>
        ";
	}
	echo $respo;
	 
	 
			
?>