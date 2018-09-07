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
<h1 id='hea2'>No of personnel in field/HQ in each wing</h1>
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
	        <th>O/o AG/PAG/PD(C)</th>
	        <th>Wing</th>
			<th>Designation</th>
			<th>HQ</th>
			<th>FIELD</th>
			</tr>
		    ";

		
		$query="select wng.dmn_dscrptn wing,brn.dmn_dscrptn branch,
		        cdr.dmn_dscrptn cadre,a.ps_cdr_id,a.cnt hqcount,b.cnt fieldcount
		        from 
		        (
		        	select a0.ps_wing ps_wing,a0.ps_brnch_id ps_brnch_id,
		               a0.ps_cdr_id ps_cdr_id,a1.cnt cnt 
		               from 
		        		(select distinct ps_wing ,ps_brnch_id,ps_cdr_id,
		                		(ps_wing||ps_brnch_id||ps_cdr_id) comb0 
		        				from 
		        				prsnl_infrmtn_systm
		        				where ps_wing like '$wing'
		        		) a0,
		        		(select ps_wing,ps_brnch_id,ps_cdr_id,count(sct.dmn_dscrptn) cnt,
		         				(ps_wing||ps_brnch_id||ps_cdr_id) comb1
								from 
								prsnl_infrmtn_systm a,estt_dmn_mstr sct
								where sct.dmn_id(+)=ps_sctn_id and sct.dmn_shrt_nm is not null
								and   ps_flg='W'
								and ps_wing like '$wing'
								group by ps_wing,ps_brnch_id,ps_cdr_id
						) a1
						where comb0=comb1(+)
				) a,

				(
					select a0.ps_wing ps_wing,a0.ps_brnch_id ps_brnch_id,
						   a0.ps_cdr_id ps_cdr_id,a1.cnt cnt 
						   from 
		        		   (select distinct ps_wing ,ps_brnch_id,ps_cdr_id,
		                		   (ps_wing||ps_brnch_id||ps_cdr_id) comb0 
		        			from 
		        			prsnl_infrmtn_systm
		        			where ps_wing like '$wing'
		        			) a0,
		        			(select ps_wing,ps_brnch_id,ps_cdr_id,count(sct.dmn_dscrptn) cnt,
		         					(ps_wing||ps_brnch_id||ps_cdr_id) comb1
							from 
							prsnl_infrmtn_systm a,estt_dmn_mstr sct
							where sct.dmn_id(+)=ps_sctn_id and sct.dmn_shrt_nm is  null
							and   ps_flg='W'
							and ps_wing like '$wing'
							group by ps_wing,ps_brnch_id,ps_cdr_id
							) a1
							where comb0=comb1(+)
				) b,
				estt_dmn_mstr wng,
				estt_dmn_mstr brn,
				estt_dmn_mstr cdr
				where 
				     (a.ps_wing||a.ps_brnch_id||a.ps_cdr_id)=(b.ps_wing||b.ps_brnch_id||b.ps_cdr_id)
				and  a.ps_wing=wng.dmn_id(+) and a.ps_brnch_id=brn.dmn_id(+) and a.ps_cdr_id=cdr.dmn_id(+)
				order by 
				        wng.dmn_dscrptn,brn.dmn_dscrptn,ps_cdr_id
				";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);
                $wingprev='km';
                $branchprev='km';
        while( $row=oci_fetch_array($statemen))
				{
				$wing=$row["WING"];
				$branch=$row["BRANCH"];
                ($wingprev!=$wing)?$wingprev=$wing:$wing='';
                ($branchprev!=$branch)?$branchprev=$branch:$branch='';
                
				$desig=$row["CADRE"];
				$hq=$row["HQCOUNT"];
				$field=$row["FIELDCOUNT"];
				
				echo "<tr>";
				echo "<td>$wing</td>";
				echo "<td>$branch</td>";
				echo "<td>$desig</td>";
				echo "<td>$hq</td>";
				echo "<td>$field</td>";
				echo "</tr>";
				
				}
		
	echo "</table>";
    }
    ?>
</body>
