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
	}
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


<?php
function explod($str,$bigstr)
  {
return preg_split("/[\s]+/", $bigstr);
  }
function remove_table_alias($str)
    {
if (array_key_exists(1,(explode('.',$str))))
	return (explode('.',$str)[1]);
else
	return $str;
    }

 function columnnamee($str)
 	{
 $lastsubelement="";
 foreach(explod(" ",$str) as $subelement)  $lastsubelement=$subelement;
 return $lastsubelement;
 	} 

 function check_for_from($str)
 	{
 $count=0;
 foreach (explod(' ',$str) as $subelem)
 		{
 if ($subelem=='from') return $count;
 $count+=1;
 		}
 return -1;
 	}

 function detect_select($str)
 	{
 foreach(explod(" ",$str) as $elem)
 	 if ($elem=='select') return True;
 	return False;
 	}



if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('q',$_POST)))
			{
			echo '<script>';
			echo 'document.getElementById("q").style.visibilty="hidden"';
			echo '</script>';
			$elemsInquery=explode(',',$_POST['q']);
			//$query=str_replace(' ', '',$_POST['q']);
			$qelems=array();
			$tables=array();
			$i=-1;
			$j=0;
			$frompassed=False;
			foreach ($elemsInquery as $elem)
				{
			$i+=1;
			if (  detect_select($elem))
					{
					$qelems[$i]=remove_table_alias(columnnamee($elem));
					continue;
					}

					if (array_key_exists(1,(explod(' ',$elem))))
					{
					if ((  check_for_from($elem)!=-1) && !($frompassed))
						{
					$frompassed=True;
					$qelems[$i]=remove_table_alias(explod(" ",$elem)[check_for_from($elem)-1]);
					$tables[$j]=strtolower(explod(' ',$elem)[check_for_from($elem)+1]);$j+=1;
					
					
						}
					else
						{
					if(!($frompassed)) $qelems[$i]=remove_table_alias(columnnamee($elem));
						}

					continue;
				    }
			if ($frompassed)
					{
			$tables[$j]=strtolower(explod(' ',$elem)[0]);$j+=1;
			continue;
					}

			if (!($frompassed)) $qelems[$i]=remove_table_alias(columnnamee($elem));
			
				}
			//echo 'columns are'.'<br>';foreach ($qelems as $col)	{	echo $col.'<br>';}
			//echo 'tables are '.'<br>';foreach ($tables as $table){	echo $table.'<br>';	}
			echo '<table>';
			echo '<tr>';
			foreach ($qelems as $col) echo '<th>'.$col.'</th>';
			echo '</tr>';

			//$conn=oci_connect("km","rt","localhost/test2");
			$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
			$query=$_POST['q'];
			$statemen=oci_parse($conn,$query);
			oci_execute($statemen);
			while ($row = oci_fetch_array($statemen))
				{
			echo '<tr>';
			foreach ($qelems as $col)
					{
				$col=strtoupper($col);
                //echo $row[$col];
                echo '<td>'.$row[$col].'</td>';
			    	}
			echo '</tr>';
					
				}
			echo '</table>';
			}
?>



</body>