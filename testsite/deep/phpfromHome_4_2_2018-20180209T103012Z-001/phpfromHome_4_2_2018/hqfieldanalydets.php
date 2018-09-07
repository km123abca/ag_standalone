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
<script>
function makelistt(rltn,typ,dest)
				{
				
				if (rltn.length!=0)
					{
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
						document.getElementById(dest).innerHTML="";
						document.getElementById(dest).innerHTML+=this.responseText;
							}
						};
				xmlhttp.open("GET", "interfere.php?q=" + rltn+"&n="+ typ+"&dest="+ dest, true);
		    	 xmlhttp.send();
					}
				}
makelistt('%','01','cadre');
</script>
<h1 id='hea2'>personnel in field/HQ in each wing</h1>
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
	Designation:<select id="cadre" name="cadre"   
	            >   
	            <option value='%' >select all</option>
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
    $cadre=$_POST["cadre"];
    //$_SESSION['cadre']=$cadre;
	echo    "<table id='t01'>";
	echo	"<tr>
	        <th>O/o AG/PAG/PD(C)</th>
	        <th>Wing</th>
			<th>Designation</th>
			<th>Name</th>
			<th>HQ/Field</th>
			</tr>
		    ";

		
		$query="select wng.dmn_dscrptn wing,brn.dmn_dscrptn branch,cdr.dmn_dscrptn cadre,
					   sec.dmn_dscrptn section,
					   ps_nm,nvl(sec.dmn_shrt_nm,'field') hqf
					   from 
					   prsnl_infrmtn_systm,estt_dmn_mstr wng,estt_dmn_mstr brn,
					   estt_dmn_mstr cdr,estt_dmn_mstr sec
					   where 
					   wng.dmn_id(+)=ps_wing and brn.dmn_id(+)=ps_brnch_id and
					   cdr.dmn_id(+)=ps_cdr_id and sec.dmn_id(+)=ps_sctn_id
					   and ps_flg='W'  and ps_wing like '$wing'
					   and ps_cdr_id like '$cadre'
					   order by 
					   ps_wing,ps_brnch_id,ps_cdr_id
				";
		$statemen=oci_parse($conn,$query);
		oci_execute($statemen);
                $wingprev='km';
                $branchprev='km';
                $desigprev='km';
                $cnt=1;
        while( $row=oci_fetch_array($statemen))
				{
				$wing=$row["WING"];
				$branch=$row["BRANCH"];
				$desig=$row["CADRE"];
                ($wingprev!=$wing)?$wingprev=$wing:$wing='';
                //($branchprev!=$branch)?$branchprev=$branch:$branch='';
                if ($branchprev!=$branch)
                		{
                		$branchprev=$branch;
                		$cnt=1;
                   		}
                else
                	    {
                	    $branch='';
                	    }
                if ($desigprev!=$desig)
                		{
                		$desigprev=$desig;
                    	$cnt=1;
                   		}
				
				$nm=$row["PS_NM"];
				$hqf=$row["HQF"];
				
				
				echo "<tr>";
				echo "<td>$wing</td>";
				echo "<td>$branch</td>";
				echo "<td>$desig</td>";
				echo "<td>$cnt.$nm</td>";
				echo "<td>$hqf</td>";
				echo "</tr>";
				$cnt+=1;
				}
		
	echo "</table>";
    }
    ?>
</body>
