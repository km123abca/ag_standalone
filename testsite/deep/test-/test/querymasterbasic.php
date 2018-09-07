<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if($fgmembersite->Userrole()=='basic')
  {
  	$fgmembersite->RedirectToURL("nomansland.php");
  	exit;
  }

?>

<head>
	<style>
	#in1
	{
		float:left;
		clear:left;
	}
	table, th, td 
	{
    border: 1px solid black;
     text-align: left;
    }
	th
	{
		align:"left";
	}
	</style>
	<script>
	function hidestuff()
	{
	document.getElementById("form1").style.visibility="hidden";
	document.getElementById("form1").style.position="absolute";
	document.getElementById("form1").style.float="left";
	document.getElementById("q").style.visibility="hidden";
	document.getElementById("q").style.position="absolute";
	document.getElementById("q").style.float="left";
	document.getElementById("varbo").style.float="right";
	}
/*
    function updatequerry()
	{
		
    document.getElementById("q").innerHTML=						;
	}
	*/
</script>
</head>


<body>






<form method="post" id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<strong>Type your query here</strong>: <br>
 <textarea id="q" name="q"  rows="30" cols="120" style="visibility:visible;">select ps_nm name,ps_idn office_id,sec.dmn_dscrptn section,wng.dmn_dscrptn wing,cd.dmn_dscrptn designation from prsnl_infrmtn_systm,estt_dmn_mstr sec,estt_dmn_mstr wng,estt_dmn_mstr cd where ps_flg='W' and ps_wing=wng.dmn_id(+) and ps_sctn_id=sec.dmn_id(+) and ps_cdr_id=cd.dmn_id(+) order by ps_wing,ps_cdr_id,ps_nm
 </textarea>  <br>
 
 
<input type="submit" name="submit" value="execute" >
<button type="button" onClick="hidestuff()">hide</button>

</form>
<p id='varbo'><a href='welcomeuser.php'> <f>Main Page</f></a></p>


<?php


if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('q',$_POST)))
			{
			echo '<script>';
			echo 'document.getElementById("q").style.visibilty="hidden"';
			echo '</script>';
			
			
				
			
			$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
			$query=$_POST['q'];
			// $_SESSION["curquery"]=$query;
			$statemen=oci_parse($conn,$query);
			oci_execute($statemen);
			$firstrow=True;
			echo '<table>';
			while ($row = oci_fetch_array($statemen))
				{   $rowsel=0;
					if ($firstrow)
					{
					echo '<tr>';
					foreach($row as $key=>$val)
						{
					$rowsel+=1;
					if (($rowsel%2)==0)									
                    echo '<th>'.$key.'</th>';
                    	}				
					echo '</tr>';
				    }  
				    $firstrow=False;
				    $rowsel=0;
				    echo '<tr>';
					foreach($row as $key=>$val)	
						{	
					$rowsel+=1;		
					if (($rowsel%2)==0)						
                    echo '<td>'.$val.'</td>';
                    	}				
					echo '</tr>';		
					
				}
			echo '</table>';
			}
?>



</body>