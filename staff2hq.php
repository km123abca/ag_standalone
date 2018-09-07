<head>
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
<style>
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
							#hea2
							{
							text-align: center;
							float:left;
							width:100%;
                    		font-weight: bold;
                    		background-color:#eee; 
							}

</style>
<h1 id='hea2'>Staff Position to be uploaded to Hqrs</h1>
</head>

<body>
    <a href="index.php" >back to main page</a>
    <fieldset>

    <legend>Select an Office</legend>
    <form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Office:<select id="wing" name="wing"            
           >  
          <option value='%' <?php echo getsel('%');?> >select all</option>
	      <option value='W01' <?php echo getsel('W01');?>>GSSA</option>
	      <option value='W11' <?php echo getsel('W11');?>>ERSA</option>
	      <option value='W21' <?php echo getsel('W21');?>>PD Central</option>
	      </select>
	<input type="submit" name="list" id="subut" > 
    </form>
    </fieldset>
    <?php

    function getsel($str)
    	{
        $disp='';
    	if (isset($_POST["wing"]))
    	   {
    	   	$disp=($str==($_POST["wing"]))?'selected':'';
    	   }
    	return $disp;
    	}

    if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing',$_POST)))
    {
    $wing=$_POST["wing"];
	echo    "<table id='t01'>";
	echo	"<tr>
			<th>Cadre</th>
			<th>TVM</th>
			<th>TCR</th>
			<th>EKM</th>
			<th>KTM</th>
			<th>KDE</th>
			<th>Male</th>
			<th>Female</th>
			<th>UR</th>
			<th>SC</th>
			<th>ST</th>
			<th>OBC</th>
			<th>ExService</th>
			<th>OH</th>
			<th>VH</th>
			<th>HH</th>
			<th>Sum</th>
			</tr>
		    ";

		
		$query="select dmn_dscrptn cadre,c1 tvm,c2 tcr,c3 ekm,c4 ktm,c5 kde,c7 male,c8 female,
cg gen,csc sc,cst st,cobc obc,cex exservice,cjoh oh,cjvh vh,cjhh hh,
c6 total
from
( select distinct ps_cdr_id cd from prsnl_infrmtn_systm  where  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19') ) aa,

(select ps_cdr_id cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where
 ps_room_no='TVM' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)a,

(select ps_cdr_id cd2,count(ps_cdr_id) c2
from prsnl_infrmtn_systm where
 ps_room_no='TCR' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id) b,

(select ps_cdr_id cd3,count(ps_cdr_id) c3
from prsnl_infrmtn_systm where
 ps_room_no='EKM' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id) c,

(select ps_cdr_id cd4,count(ps_cdr_id)  c4
from prsnl_infrmtn_systm where
 ps_room_no='KTM' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id) d,

(select ps_cdr_id cd5,count(ps_cdr_id) c5
from prsnl_infrmtn_systm where
 ps_room_no='KDE' and ps_wing like '$wing'  AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id) e,

(select ps_cdr_id cd6,count(ps_cdr_id) c6
from prsnl_infrmtn_systm where
                                       ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)f,

(select ps_cdr_id cd7,count(ps_cdr_id) c7 from prsnl_infrmtn_systm where
 nvl(ps_sx_typ,'M')='M' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)g,

(select ps_cdr_id cd8,count(ps_cdr_id) c8 from prsnl_infrmtn_systm where
 ps_sx_typ='F' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)h,

(select ps_cdr_id cdg,count(ps_cdr_id) cg from prsnl_infrmtn_systm where
 NVL(sr_sc_st_n,'GL')='GL' and nvl(PS_EXSM_FLG,'N')<>'Y' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)ig,

(select ps_cdr_id cdsc,count(ps_cdr_id) csc from prsnl_infrmtn_systm where
 sr_sc_st_n='SC' and nvl(PS_EXSM_FLG,'N')<>'Y' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)isc,

(select ps_cdr_id cdst,count(ps_cdr_id) cst from prsnl_infrmtn_systm where
 sr_sc_st_n='ST' and nvl(PS_EXSM_FLG,'N')<>'Y' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)ist,

(select ps_cdr_id cdobc,count(ps_cdr_id) cobc from prsnl_infrmtn_systm where
 sr_sc_st_n='OBC' and nvl(PS_EXSM_FLG,'N')<>'Y' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)iobc,

(select ps_cdr_id cdex,count(ps_cdr_id) cex from prsnl_infrmtn_systm where
 nvl(PS_EXSM_FLG,'N')='Y' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)iex,

(select ps_cdr_id cdjoh,count(ps_cdr_id) cjoh from prsnl_infrmtn_systm where
 nvl(PS_PH_STTS,'N')='Y' and nvl(PS_PH_DTLS,'OH')='OH' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)joh,

(select ps_cdr_id cdjhh,count(ps_cdr_id) cjhh from prsnl_infrmtn_systm where
 nvl(PS_PH_STTS,'N')='Y' and nvl(PS_PH_DTLS,'OH')='HH' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)jhh,

(select ps_cdr_id cdjvh,count(ps_cdr_id) cjvh from prsnl_infrmtn_systm where
 nvl(PS_PH_STTS,'N')='Y' and nvl(PS_PH_DTLS,'OH')='VH' and ps_wing like '$wing' AND   ps_flg='W'
and  ps_cdr_id not in ('DB24','DB25','DB26','DB27','DB28','DB29','DB36',
                                     'DC06','DC08','DC14','DC15','DC16','DC19')
group by ps_cdr_id)jvh,

estt_dmn_mstr
where dmn_id(+)=cd and
cd=cd1(+) and cd=cd2(+) and cd=cd3(+)  and cd=cd4(+) and
cd=cd5(+)and cd=cd6(+) and cd=cd7(+) and cd=cd8(+)
and cd=cdg(+) and cd=cdsc(+) and cd=cdst(+)  and cd=cdobc(+)
and cd=cdex(+) and cd=cdjoh(+) and cd=cdjhh(+) and cd=cdjvh(+)
order by decode(cd,'DA00',1,'DA01',2,'DA03',3,'DA04',4,'DA08',5,'DA07',6,'DB01',7,'DB02',8,'DB06',9,'DB04',10,'DB05',11,'DB07',12,
                'DB09',13,'DB11',14,'DB14',15,'DB37',16,'DB13',17,'DB18',18,'DB20',19,'DB19',20,'DB21',21,'DC01',22,'DC03',23,
                'DC05',24,'DC13',25,'DC10',26,'DC11',27,'DC18',28,'DD01',29,'DB03',30,'DB08',31,'DB12',32,'DC17',33,'DC07',34,35)";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);
                
		while( $row=oci_fetch_array($statemen))
				{
				$cdr=$row["CADRE"];
				$tvm=$row["TVM"];
				$tcr=$row["TCR"];
				$ekm=$row["EKM"];
				$ktm=$row["KTM"];
				$kde=$row["KDE"];
				$male=$row["MALE"];
				$female=$row["FEMALE"];
				$gen=$row["GEN"];
				$sc=$row["SC"];
				$st=$row["ST"];
				$obc=$row["OBC"];
				$exservice=$row["EXSERVICE"];
				$oh=$row["OH"];
				$vh=$row["VH"];
				$hh=$row["HH"];
				$tot=$row["TOTAL"];

				
				echo "<tr>";
				echo "<td>$cdr</td>";
				echo "<td>$tvm</td>";
				echo "<td>$tcr</td>";
				echo "<td>$ekm</td>";
				echo "<td>$ktm</td>";
				echo "<td>$kde</td>";
				echo "<td>$male</td>";
				echo "<td>$female</td>";
				echo "<td>$gen</td>";
				echo "<td>$sc</td>";
				echo "<td>$st</td>";
				echo "<td>$obc</td>";
				echo "<td>$exservice</td>";
				echo "<td>$oh</td>";
				echo "<td>$vh</td>";
				echo "<td>$hh</td>";
				echo "<td>$tot</tot>";
				echo "</tr>";
				
				}
		
	echo "</table>";
    }
	?>

<?php
	if (!(isset($query)))
$query="select ps_nm from prsnl_infrmtn_systm";
$nstr=$query;
  $nstr = preg_replace('/[\r\n\t\s]/', '^', $nstr);
  $nstr = preg_replace('/[+]/', '__', $nstr);
  $nstr = preg_replace('/[\']/', 'nmn', $nstr);
  echo "<a href='getthisinexcel.php?modq=$nstr'>Download as excel</a> ";
?>
</body>