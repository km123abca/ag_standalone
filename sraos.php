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
<h1 id='hea2'>Sr AO/AOs reporting under each Group Officer</h1>
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
			<th>Group Officer</th>
			<th>Wing</th>
			<th>Reporting officer</th>
			<th>Designation</th>
			<th>Section</th>
			<th>hq?</th>
		    </tr>
		    ";

		
		$query="select  a.ps_nm DAG,a.branch branch,
		                b.ps_nm reporting_officer,b.cadre designation,b.section section,
		                decode(b.dec,'HQ','Hqrs','Field') hq
		                from
                            (select ps_nm,ps_brnch_id,brn.dmn_dscrptn branch,
                                    ps_cdr_id,ps_wing 
                                    from 
                                    prsnl_infrmtn_systm,estt_dmn_mstr brn 
									where brn.dmn_id(+)=ps_brnch_id and ps_flg='W' and 
									ps_cdr_id in ('DA00','DA01','DA02','DA04','DA05','DA07','DA08')
							) a,
							(select ps_nm,ps_brnch_id,cdr.dmn_dscrptn cadre,sec.dmn_dscrptn section,
							        ps_cdr_id,sec.dmn_shrt_nm dec
									from 
									prsnl_infrmtn_systm,estt_dmn_mstr cdr,estt_dmn_mstr sec
									where cdr.dmn_id(+)=ps_cdr_id and sec.dmn_id(+)=ps_sctn_id and 
									ps_flg='W' and ps_cdr_id in ('DB01','DB03','DB04','DB06','DB02','DB04')
							) b
						where a.ps_brnch_id=b.ps_brnch_id(+) and a.ps_wing like ('$wing')
						order by a.ps_wing,a.ps_cdr_id,a.ps_brnch_id,b.ps_cdr_id,decode(b.dec,'HQ','Hqrs','Field')";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);
                $dagprev='km';
                $branchprev='km';
                $cnt=1;
		while( $row=oci_fetch_array($statemen))
				{
				$dag=$row["DAG"];
				$branch=$row["BRANCH"];
                ($dagprev!=$dag)?$dagprev=$dag:$dag='';
                if ($branchprev!=$branch) $cnt=1;
                ($branchprev!=$branch)?$branchprev=$branch:$branch='';
                
				$officer=$row["REPORTING_OFFICER"];
				$desig=$row["DESIGNATION"];
				$section=$row["SECTION"];
				$hq=$row["HQ"];
				echo "<tr>";
				echo "<td>$dag</td>";
				echo "<td>$branch</td>";
				echo "<td>$cnt.$officer</td>";
				echo "<td>$desig</td>";
				echo "<td>$section</td>";
				echo "<td>$hq</td>";
				echo "</tr>";
				$cnt+=1;
				}
		
	echo "</table>";
    }
	?>
</body>