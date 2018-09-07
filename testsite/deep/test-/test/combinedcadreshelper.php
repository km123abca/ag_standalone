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
   $wingg=$_REQUEST["r"];
   $query="select cd,dmn_dscrptn cadre,c1 tvm,c2 tcr,c3 ekm,c4 ktm,c5 kde,c6 total 
            from
            (select distinct 
            decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
            cd from prsnl_infrmtn_systm 
            union select 'sum' cd from dual
            ) aa,

            (select 
            decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS') 
            cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where 
                    ps_room_no='TVM' and ps_wing='$wingg' AND   ps_flg='W'
                    group by 
                    decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
                   union select 'sum' cd1,count(ps_idn) c1 from prsnl_infrmtn_systm 
                   where ps_room_no='TVM' and ps_wing='$wingg' AND   ps_flg='W'  
                   and ps_cdr_id not in ('DC19','DB36','DB29','DB28','DC16','DB27','DA10','DB26')                 
                    )a,

      (select 
      decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
       cd2,count(ps_cdr_id) c2 
          from prsnl_infrmtn_systm where 
          ps_room_no='TCR' and ps_wing='$wingg' AND   ps_flg='W'
          group by 
          decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
                   union select 'sum' cd2,count(ps_idn) c2 from prsnl_infrmtn_systm 
                   where ps_room_no='TCR' and ps_wing='$wingg' AND   ps_flg='W'
                   and ps_cdr_id not in ('DC19','DB36','DB29','DB28','DC16','DB27','DA10','DB26')
          ) b,

      (select 
      decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
       cd3,count(ps_cdr_id) c3 
          from prsnl_infrmtn_systm where 
          ps_room_no='EKM' and ps_wing='$wingg' AND   ps_flg='W'
          group by 
          decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
                   union select 'sum' cd3,count(ps_idn) c3 from prsnl_infrmtn_systm 
                   where ps_room_no='EKM' and ps_wing='$wingg' AND   ps_flg='W'
                   and ps_cdr_id not in ('DC19','DB36','DB29','DB28','DC16','DB27','DA10','DB26')
          ) c, 

      (select 
      decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
       cd4,count(ps_cdr_id)  c4
          from prsnl_infrmtn_systm where 
          ps_room_no='KTM' and ps_wing='$wingg' AND   ps_flg='W'
          group by 
          decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
                   union select 'sum' cd4,count(ps_idn) c4 from prsnl_infrmtn_systm 
                   where ps_room_no='KTM' and ps_wing='$wingg' AND   ps_flg='W'
                   and ps_cdr_id not in ('DC19','DB36','DB29','DB28','DC16','DB27','DA10','DB26')
          ) d,
      (select 
      decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
       cd5,count(ps_cdr_id) c5 
          from prsnl_infrmtn_systm where 
          ps_room_no='KDE' and ps_wing='$wingg' AND   ps_flg='W'
          group by 
          decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
                   union select 'sum' cd5,count(ps_idn) c5 from prsnl_infrmtn_systm 
                   where ps_room_no='KDE' and ps_wing='$wingg' AND   ps_flg='W'
                   and ps_cdr_id not in ('DC19','DB36','DB29','DB28','DC16','DB27','DA10','DB26')
          ) e,

      (select 
      decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
       cd6,count(ps_cdr_id) c6 
          from prsnl_infrmtn_systm where 
          ps_wing='$wingg' AND   ps_flg='W'
          group by 
          decode(ps_cdr_id,'DA00','GR.A','DA01','GR.A','DA02','GR.A','DA03','GR.A','DA04','GR.A','DA05','GR.A','DA07','GR.A','DA08','GR.A',
                   'DB01','Sr AO/AO','DB02','Sr AO/AO','DB03','Sr AO/AO','DB04','Sr AO/AO','DB05','Sr AO/AO','DB06','Sr AO/AO', 
                   'DB11','AAO/Supr','DB14','AAO/Supr','DB18','AAO/Supr','DB37','AAO/Supr',
                   'DC05','Adr/SrAdr','DC01','Adr/SrAdr','DB19','Adr/SrAdr',
                   'DB09','Hindi Posts','DB20','Hindi Posts','DC03','Hindi Posts',
                   'DB13','PS/SrPS','DB07','PS/SrPS','DB21','PS/SrPS','DC13','PS/SrPS',
                   'DB03','EDP','DB08','EDP','DB12','EDP','DC07','EDP','DC07','EDP','DC17','EDP',
                   'DD01','Clerk/MTS','DC10','Clerk/MTS','DC18','Clerk/MTS','DC11','Clerk/MTS')
                   union select 'sum' cd6,count(ps_idn) c6 from prsnl_infrmtn_systm 
                   where  ps_wing='$wingg' AND   ps_flg='W'
                   and ps_cdr_id not in ('DC19','DB36','DB29','DB28','DC16','DB27','DA10','DB26')
          ) f,

      estt_dmn_mstr 

    where dmn_id(+)=cd and
              cd=cd1(+) and 
              cd=cd2(+) and 
              cd=cd3(+) and 
              cd=cd4(+) and
        cd=cd5(+) and
        cd=cd6(+)
         ";

	
	
	
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
 $cadre=$row["CD"];
 $tvmcount=$row["TVM"];
 $tcrcount=$row["TCR"];
 $ekmcount=$row["EKM"];
 $ktycount=$row["KTM"];
 $kdecount=$row["KDE"];
 $sum=$row["TOTAL"];
 //echo 'the session variable is now:'.$_SESSION['toggle'];
 echo "<tr> 
       <td class='bl'>$cadre</td> 
       <td>$tvmcount</td>
       <td>$tcrcount</td> 
       <td>$ekmcount</td>
       <td>$ktycount</td>  
       <td>$kdecount</td>
       <td>$sum</td> 
        </tr>";
	}
	echo $respo;
	 
	 
			
?>