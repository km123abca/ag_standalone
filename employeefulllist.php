<?PHP
require_once("./include/membersite_config.php");
//require_once("phpfuncs.php");   ACTIVATE THIS FOR DEBUGGING ONLY

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

	function descr($dmnid,$conn)
	    { 
	    $dmnid=strtoupper($dmnid); 
        if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}
	    $query="select dmn_dscrptn from estt_dmn_mstr where 
	              dmn_id like"." '$dmnid'";
	    $statemen=oci_parse($conn,$query);
	    oci_execute($statemen);
	    if ( $row=oci_fetch_array($statemen))
	 	    {   
	 		return $row["DMN_DSCRPTN"];
	        }
	    return 'Not Given';
	    }
?>

<head>
<h1 id="offheading">  Office of the Accountant General, Thiruvananthapuram</h1>
<style>
							#offheading
							{
							font-size:200%;
							background-color:yellow;
							text-align:center;
							}
							.lg
							{
							float:left;
							/*border:2px solid black;*/
							width:50%;
							}
							.flg
							{
							float:left;
							/*border:2px solid black;*/
							width:100%;
							}

							@media(min-width:200px) and (max-width:767px){
							.flg2
							{
								float:left;
								width:100%;
								/*border:2px solid black;*/
							}
																		 }

							@media(min-width:768px) and (max-width:992px){
							.flg2
							{
								float:left;
								width:50%;
								/*border:2px solid black;*/
							}
																		 }

						    @media(min-width:993px) {
							.flg2
							{
								float:left;
								width:33%;
								/*border:2px solid black;*/
							}
													}
							.inv
							{
							visibility: hidden;
							}
							.floatlef
							{
							float:left;
							clear:both;
							}

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

							select
							{
							width:96%;
							}
							#form1
							{
							margin-left: 25%;
							}

							legend
							{
							font-weight: bold;
							}
							#fs1
							{
							width:50%;
							}
							#fs_v2
							{
								display:block;
							}
							.clred
							{
							color:red;
							}
							.clgreen
							{
							color:green;
							}
</style>


<script>
function makelistt(rltn,typ,dest,defval='none',relval='none')
				{
				
				if (rltn.length!=0)
					{
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
					document.getElementById(dest).innerHTML=this.responseText;
							}
						};
				xmlhttp.open("GET", "interfere.php?q=" + rltn+"&n="+ typ+"&dest="+dest+"&defval="+defval, true);
		    	 xmlhttp.send();
					}
				}
function vallist(col,elem,opto='no',defval='none')
				{
				
				
				
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function()
						{
					if (this.readyState == 4 && this.status == 200)
							{    //console.log('The resposeText received is this '+this.responseText);
					document.getElementById(elem).innerHTML=this.responseText;
					//console.log(this.responseText);
							}
						};
				if (opto!='desc')
				xmlhttp.open("GET", "vallist2.php?q=" + col, true);
			    else
			    xmlhttp.open("GET", "vallist2.php?q=" + col+"&b="+'desc'+"&big=y"+"&defval="+defval, true);
		    	 xmlhttp.send();
					
				}

	function makeinviz()
				{
				  	document.getElementById("form1").style.visibility="hidden";
				  	document.getElementById("form1").style.position="absolute";
				  	document.getElementById("form1").style.float="left";
				  	document.getElementById("lifeline").style.visibility="visible";
				  	
				}

				<?php
				if ($fgmembersite->SafeDisplay('wing')=='') $relwing='%';
				else $relwing=$fgmembersite->SafeDisplay('wing');

				if ($fgmembersite->SafeDisplay('branch')=='') $relbranch='%';
				else $relbranch=$fgmembersite->SafeDisplay('branch');


				?>
				makelistt(<?php  echo  "'".$relwing."'";?>,'03','branch',<?php  echo  "'".$fgmembersite->SafeDisplay('branch')."'";?>);
				makelistt('%','01','cadre',<?php  echo  "'".$fgmembersite->SafeDisplay('cadre')."'";?>);
				makelistt(<?php  echo  "'".$relbranch."'";?>,'17','section',<?php  echo  "'".$fgmembersite->SafeDisplay('section')."'";?>);
				vallist('sr_sc_st_n','cat','desc',<?php  echo  "'".$fgmembersite->SafeDisplay('cat')."'";?>);

				function altercd()
					{
				//console.log('hello');
				var it_m=document.getElementById('fs_v2');
				var cha='none';
				varstat=document.getElementById('c').checked;
				if (varstat==true)  cha='block';
				else                cha='none';
				document.getElementById('fs_v2').style.display=cha;
					}
</script>

</head>



<body>

<form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset id="fs1">
	<legend>Filter by</legend>

	<?php  
		//echo $fgmembersite->SafeDisplay('wing');
		$selstrs=array('%'=>'selected','W01'=>'','W11'=>'','W21'=>'');
		$wingsel=$fgmembersite->SafeDisplay('wing');
		$wingsel=($wingsel=='')?'%':$wingsel;
		foreach ($selstrs as $ke=>$va)
			{
			$selstrs[$ke]=(($ke==$wingsel)?'selected':'');
			}
	    
		//$brstr="<option value=\'%\'";

			$roomstrs=array('%'=>'selected','TCR'=>'','TVM'=>'','KTM'=>'','EKM'=>'','KDE'=>'');
		$roomsel=$fgmembersite->SafeDisplay('room');
		$roomsel=($roomsel=='')?'%':$roomsel;
		foreach ($roomstrs as $ke=>$va)
			{
			$roomstrs[$ke]=(($ke==$roomsel)?'selected':'');
			}

		?>
	<lab class="lg bl">Wing</lab>   
	      <inp class="lg">
	      :<select id="wing" name="wing"  onchange="makelistt(this.value,'03','branch')"  >  
          <option value='%'   <?php  echo $selstrs['%'];  ?>   >select all</option>
	      <option value='W01' <?php  echo $selstrs['W01'];?> >GSSA</option>
	      <option value='W11' <?php  echo $selstrs['W11'];?> >ERSA</option>
	      <option value='W21' <?php  echo $selstrs['W21'];?> >PD Central</option>
	      </select>
	      </inp>

	 <lab class="lg bl">Branch</lab>   
	      <inp class="lg">
	      :<select id="branch" name="branch"  onchange="makelistt(this.value,'17','section')" >  
	      <option value='%' selected>select all</option>
          </select>
	      </inp>


	  <lab class="lg bl">Section</lab>   
	      <inp class="lg">
	      :<select id="section" name="section"   >  
	      <option value='%' selected>select all</option>
          </select>
	      </inp>

	   <lab class="lg bl">Designation</lab>   
	      <inp class="lg">
	      :<select id="cadre" name="cadre"   >   
	      <option value='%' selected>select all</option>
          		
	      </select>
	      </inp>

	    <lab class="lg bl">HQ</lab>   
	      <inp class="lg">
	      :<select id="room" name="room"    >  
          <option value='%' <?php  echo $roomstrs['%'];  ?> >select all</option>
	      <option value='TVM' <?php  echo $roomstrs['TVM'];  ?> >TVM</option>
	      <option value='EKM' <?php  echo $roomstrs['EKM'];  ?> >Cochin</option>
	      <option value='TCR' <?php  echo $roomstrs['TCR'];  ?> >Trichur</option>
	      <option value='KDE' <?php  echo $roomstrs['KDE'];  ?> >Kozhikode</option>
	      <option value='KTM' <?php  echo $roomstrs['KTM'];  ?> >Kottayam</option>
	      </select>
	      </inp>

	      <lab class="lg bl">Category</lab>   
	      <inp class="lg">
	      :<select id="cat" name="cat"    >  
          
	      </select>
	      </inp>


	
</fieldset>

<fieldset class="lg">
	<legend>What need to be displayed </legend>
	<lab class="flg"><input  type='checkbox' id='w' name='w' value='ps_wing' 
	                         >Wing</lab>
	<lab class="flg"><input  type='checkbox' id='b' name='b' value='ps_brnch_id' >
							 Branch</lab>
	<lab class="flg"><input  type='checkbox' id='s' name='s' value='ps_sctn_id' >
	                         Section</lab>
	<lab class="flg"><input  type='checkbox' id='c' name='c' value='ps_cdr_id' onclick='altercd()'>
	                         Cadre</lab>
	<lab class="flg"><input  type='checkbox' id='r' name='r' value='ps_room_no'  >
					         HQ</lab>
	<lab class="flg"><input  type='checkbox' id='ct' name='ct' value='sr_sc_st_n' >
					         Catergory</lab>
	<lab class="flg"><input  type='checkbox' id='nm' name='nm' value='ps_nm' >
					         Employee Names</lab>
</fieldset>
<fieldset class="lg" id='fs_v2'>
	<legend>Select Designations to be displayed </legend>

	<lab class="flg2 clred"><input  type='checkbox' id='all_desig' name='all_desig' value='all_desig' 
	                         >All</lab>
	<lab class="flg2"><input  type='checkbox' id='pag' name='pag' value='pag' 
	                         >PAG</lab>
	<lab class="flg2 clred"><input  type='checkbox' id='ag' name='ag' value='ag' 
	                         >AG</lab>
	<lab class="flg2"><input  type='checkbox' id='pdc' name='pdc' value='pdc' 
	                         >PD(C)</lab>

	<lab class="flg2"><input  type='checkbox' id='srdag' name='srdag' value='srdag' 
	                         >Sr DAG</lab>
	<lab class="flg2 clred"><input  type='checkbox' id='dag' name='dag' value='dag' 
	                         >DAG</lab>
	<lab class="flg2"><input  type='checkbox' id='dd' name='dd' value='dd' 
	                         >DD</lab>
	<lab class="flg2"><input  type='checkbox' id='wo' name='wo' value='wo' 
	                         >WlfOfr</lab>



	<lab class="flg2"><input  type='checkbox' id='aag' name='aag' value='aag' >AAG</lab>
	<lab class="flg2"><input  type='checkbox' id='dagh' name='dagh' value='dagh' >DAG(adhoc)</lab>
	<lab class="flg2"><input  type='checkbox' id='dir' name='dir' value='dir' >Director</lab>
	<lab class="flg2 clred"><input  type='checkbox' id='sao' name='sao' value='sao' >SrAO</lab>
	<lab class="flg2 clred"><input  type='checkbox' id='saoc' name='saoc' value='saoc' >SrAO(c)</lab>
	<lab class="flg2 clred"><input  type='checkbox' id='dm' name='dm' value='dm' >DM</lab>
	<lab class="flg2 clred"><input  type='checkbox' id='ao' name='ao' value='ao' >AO</lab>
	<lab class="flg2"><input  type='checkbox' id='aoc' name='aoc' value='aoc' >AO(c)</lab>
	<lab class="flg2"><input  type='checkbox' id='saol' name='saol' value='saol' >SrAO(L)</lab>
	<lab class="flg2"><input  type='checkbox' id='sps' name='sps' value='sps' >SrPS</lab>
	<lab class="flg2"><input  type='checkbox' id='sdp' name='sdp' value='sdp' >SrDP</lab>
	<lab class="flg2"><input  type='checkbox' id='ho' name='ho' value='ho' >HO</lab>
	<lab class="flg2"><input  type='checkbox' id='aao' name='aao' value='aao' >AAO</lab>
	<lab class="flg2"><input  type='checkbox' id='dp' name='dp' value='dp' >DP</lab>
	<lab class="flg2"><input  type='checkbox' id='psec' name='psec' value='psec' >PS</lab>
	<lab class="flg2"><input  type='checkbox' id='aao' name='aao' value='aao' >AAO(c)</lab>
	<lab class="flg2"><input  type='checkbox' id='so' name='so' value='so' >SO</lab>
	<lab class="flg2"><input  type='checkbox' id='aso' name='aso' value='aso' >SO(adhoc)</lab>
	<lab class="flg2"><input  type='checkbox' id='soc' name='soc' value='soc' >SO(c)</lab>
	<lab class="flg2"><input  type='checkbox' id='spv' name='spv' value='spv' >Supr</lab>
	<lab class="flg2"><input  type='checkbox' id='wa' name='wa' value='wa' >WelfAsst</lab>
	<lab class="flg2"><input  type='checkbox' id='sht' name='sht' value='sht' >SenHT</lab>
	<lab class="flg2"><input  type='checkbox' id='sgi' name='sgi' value='sgi' >Steno(GrI)</lab>
	<lab class="flg2"><input  type='checkbox' id='deod' name='deod' value='deod' >DEO(GrD)</lab>


	<lab class="flg2"><input  type='checkbox' id='saodep' name='saodep' value='saodep' >SrAO(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='saodepc' name='saodepc' value='saodepc' >SrAO(c)(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='aodep' name='aodep' value='aodep' >AO(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='aocdep' name='aocdep' value='aocdep' >AO(c)(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='aaodep' name='aaodep' value='aaodep' >AAO(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='aaocdep' name='aaocdep' value='aaocdep' >AAO(c)(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='aco' name='aco' value='aco' >AcO</lab>
	<lab class="flg2"><input  type='checkbox' id='acocumia' name='acocumia' value='acocumia' >AcO,IntAdr</lab>
	<lab class="flg2"><input  type='checkbox' id='fo' name='fo' value='fo' >FO</lab>
	<lab class="flg2"><input  type='checkbox' id='fao' name='fao' value='fao' >FAO</lab>
	<lab class="flg2"><input  type='checkbox' id='rcas' name='rcas' value='rcas' >RCA</lab>
	<lab class="flg2"><input  type='checkbox' id='iao' name='iao' value='iao' >IAO</lab>
	<lab class="flg2"><input  type='checkbox' id='sgid' name='sgid' value='sgid' >SG(GrI)(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='aaol' name='aaol' value='aaol' >AAO(L)</lab>
	<lab class="flg2"><input  type='checkbox' id='sradr' name='sradr' value='sradr' >SrAdr</lab>
	<lab class="flg2"><input  type='checkbox' id='pa' name='pa' value='pa' >PA</lab>
	<lab class="flg2"><input  type='checkbox' id='jht' name='jht' value='jht' >JHT</lab>
	<lab class="flg2"><input  type='checkbox' id='adr' name='adr' value='adr' >Adr</lab>
	<lab class="flg2"><input  type='checkbox' id='sgiid' name='sgiid' value='sgiid' >SG(GrII)(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='deoa' name='deoa' value='deoa' >DEO(GrA)</lab>
	<lab class="flg2"><input  type='checkbox' id='deodep' name='deodep' value='deodep' >DEO(dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='acr' name='acr' value='acr' >AsstCareTkr</lab>
	<lab class="flg2"><input  type='checkbox' id='clrk' name='clrk' value='clrk' >Clerk</lab>
	<lab class="flg2"><input  type='checkbox' id='scd' name='scd' value='scd' >StfCarDr</lab>
	<lab class="flg2"><input  type='checkbox' id='sgii' name='sgii' value='sgii' >SG(GrII)</lab>
	<lab class="flg2"><input  type='checkbox' id='deoad' name='deoad' value='deoad' >DEO(GrA)(d)</lab>
	<lab class="flg2"><input  type='checkbox' id='adrd' name='adrd' value='adrd' >Adr(Dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='sadrd' name='sadrd' value='sadrd' >SrAdr(Dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='deob' name='deob' value='deob' >DEO(GrB)</lab>
	<lab class="flg2"><input  type='checkbox' id='to' name='to' value='to' >TelphOpr</lab>
	<lab class="flg2"><input  type='checkbox' id='jht' name='jht' value='jht' >JHT(Dep)</lab>
	<lab class="flg2"><input  type='checkbox' id='mts' name='mts' value='mts' >MTS</lab>
	                         

	
</fieldset>
<input type="submit" name="generate" id="subut" class="floatlef">
<button type="button" onclick="makeinviz()" class="floatlef">hide</button>
<a href="index.php" class="floatlef">back to main menu</a>
</form>

<a href="employeefulllist.php" id="lifeline">Back</a>
<?php 
 $boolval='true';


 if(!($fgmembersite->SafeDisplay('wing')=='')) $boolval='false'; 
 if(!($fgmembersite->SafeDisplay('branch')=='')) $boolval='false'; 
 if(!($fgmembersite->SafeDisplay('section')=='')) $boolval='false'; 
 if(!($fgmembersite->SafeDisplay('cadre')=='')) $boolval='false'; 
 if(!($fgmembersite->SafeDisplay('room')=='')) $boolval='false'; 
 if(!($fgmembersite->SafeDisplay('cat')=='')) $boolval='false'; 

 //if ($boolval) echo 'hello';
 //else echo 'heel';
 ?>
<script>
document.getElementById('c').checked=true;
document.getElementById('nm').checked=true;


document.getElementById('w').checked=<?php echo (($fgmembersite->SafeDisplay('w')=='ps_wing')?'true':'false'); ?>;
document.getElementById('b').checked=<?php echo (($fgmembersite->SafeDisplay('b')=='ps_brnch_id')?'true':'false'); ?>;
document.getElementById('s').checked=<?php echo (($fgmembersite->SafeDisplay('s')=='ps_sctn_id')?'true':'false'); ?>;
document.getElementById('c').checked=<?php echo (($fgmembersite->SafeDisplay('c')=='ps_cdr_id')?'true':$boolval); ?>;
document.getElementById('r').checked=<?php echo (($fgmembersite->SafeDisplay('r')=='ps_room_no')?'true':'false'); ?>;
document.getElementById('ct').checked=<?php echo (($fgmembersite->SafeDisplay('ct')=='sr_sc_st_n')?'true':'false'); ?>;
document.getElementById('nm').checked=<?php echo (($fgmembersite->SafeDisplay('nm')=='ps_nm')?'true':$boolval); ?>;


document.getElementById('all_desig').checked=<?php echo (($fgmembersite->SafeDisplay('all_desig')=='all_desig')?'true':'false'); ?>;
document.getElementById('ag').checked=<?php echo (($fgmembersite->SafeDisplay('ag')=='ag')?'true':'false'); ?>;
document.getElementById('pdc').checked=<?php echo (($fgmembersite->SafeDisplay('pdc')=='pdc')?'true':'false'); ?>;
document.getElementById('pag').checked=<?php echo (($fgmembersite->SafeDisplay('pag')=='pag')?'true':'false'); ?>;
document.getElementById('srdag').checked=<?php echo (($fgmembersite->SafeDisplay('srdag')=='srdag')?'true':'false'); ?>;
document.getElementById('dag').checked=<?php echo (($fgmembersite->SafeDisplay('dag')=='dag')?'true':'false'); ?>;
document.getElementById('dd').checked=<?php echo (($fgmembersite->SafeDisplay('dd')=='dd')?'true':'false'); ?>;
document.getElementById('wo').checked=<?php echo (($fgmembersite->SafeDisplay('wo')=='wo')?'true':'false'); ?>;


document.getElementById('aag').checked=<?php echo (($fgmembersite->SafeDisplay('aag')=='aag')?'true':'false'); ?>;
document.getElementById('dagh').checked=<?php echo (($fgmembersite->SafeDisplay('dagh')=='dagh')?'true':'false'); ?>;
document.getElementById('dir').checked=<?php echo (($fgmembersite->SafeDisplay('dir')=='dir')?'true':'false'); ?>;
document.getElementById('sao').checked=<?php echo (($fgmembersite->SafeDisplay('sao')=='sao')?'true':'false'); ?>;
document.getElementById('saoc').checked=<?php echo (($fgmembersite->SafeDisplay('saoc')=='saoc')?'true':'false'); ?>;
document.getElementById('dm').checked=<?php echo (($fgmembersite->SafeDisplay('dm')=='dm')?'true':'false'); ?>;
document.getElementById('ao').checked=<?php echo (($fgmembersite->SafeDisplay('ao')=='ao')?'true':'false'); ?>;
document.getElementById('aoc').checked=<?php echo (($fgmembersite->SafeDisplay('aoc')=='aoc')?'true':'false'); ?>;
document.getElementById('saol').checked=<?php echo (($fgmembersite->SafeDisplay('saol')=='saol')?'true':'false'); ?>;
document.getElementById('sps').checked=<?php echo (($fgmembersite->SafeDisplay('sps')=='sps')?'true':'false'); ?>;
document.getElementById('sdp').checked=<?php echo (($fgmembersite->SafeDisplay('sdp')=='sdp')?'true':'false'); ?>;
document.getElementById('ho').checked=<?php echo (($fgmembersite->SafeDisplay('ho')=='ho')?'true':'false'); ?>;
document.getElementById('aao').checked=<?php echo (($fgmembersite->SafeDisplay('aao')=='aao')?'true':'false'); ?>;
document.getElementById('dp').checked=<?php echo (($fgmembersite->SafeDisplay('dp')=='dp')?'true':'false'); ?>;
document.getElementById('psec').checked=<?php echo (($fgmembersite->SafeDisplay('psec')=='psec')?'true':'false'); ?>;
document.getElementById('aao').checked=<?php echo (($fgmembersite->SafeDisplay('aao')=='aao')?'true':'false'); ?>;
document.getElementById('so').checked=<?php echo (($fgmembersite->SafeDisplay('so')=='so')?'true':'false'); ?>;
document.getElementById('aso').checked=<?php echo (($fgmembersite->SafeDisplay('aso')=='aso')?'true':'false'); ?>;
document.getElementById('soc').checked=<?php echo (($fgmembersite->SafeDisplay('soc')=='soc')?'true':'false'); ?>;
document.getElementById('spv').checked=<?php echo (($fgmembersite->SafeDisplay('spv')=='spv')?'true':'false'); ?>;
document.getElementById('wa').checked=<?php echo (($fgmembersite->SafeDisplay('wa')=='wa')?'true':'false'); ?>;
document.getElementById('sht').checked=<?php echo (($fgmembersite->SafeDisplay('sht')=='sht')?'true':'false'); ?>;
document.getElementById('sgi').checked=<?php echo (($fgmembersite->SafeDisplay('sgi')=='sgi')?'true':'false'); ?>;
document.getElementById('deod').checked=<?php echo (($fgmembersite->SafeDisplay('deod')=='deod')?'true':'false'); ?>;



document.getElementById('saodep').checked=<?php echo (($fgmembersite->SafeDisplay('saodep')=='saodep')?'true':'false'); ?>;
document.getElementById('saodepc').checked=<?php echo (($fgmembersite->SafeDisplay('saodepc')=='saodepc')?'true':'false'); ?>;
document.getElementById('aodep').checked=<?php echo (($fgmembersite->SafeDisplay('aodep')=='aodep')?'true':'false'); ?>;
document.getElementById('aocdep').checked=<?php echo (($fgmembersite->SafeDisplay('aocdep')=='aocdep')?'true':'false'); ?>;
document.getElementById('aaodep').checked=<?php echo (($fgmembersite->SafeDisplay('aaodep')=='aaodep')?'true':'false'); ?>;
document.getElementById('aaocdep').checked=<?php echo (($fgmembersite->SafeDisplay('aaocdep')=='aaocdep')?'true':'false'); ?>;
document.getElementById('aco').checked=<?php echo (($fgmembersite->SafeDisplay('aco')=='aco')?'true':'false'); ?>;
document.getElementById('acocumia').checked=<?php echo (($fgmembersite->SafeDisplay('acocumia')=='acocumia')?'true':'false'); ?>;
document.getElementById('fo').checked=<?php echo (($fgmembersite->SafeDisplay('fo')=='fo')?'true':'false'); ?>;
document.getElementById('fao').checked=<?php echo (($fgmembersite->SafeDisplay('fao')=='fao')?'true':'false'); ?>;
document.getElementById('rcas').checked=<?php echo (($fgmembersite->SafeDisplay('rcas')=='rcas')?'true':'false'); ?>;
document.getElementById('iao').checked=<?php echo (($fgmembersite->SafeDisplay('iao')=='iao')?'true':'false'); ?>;
document.getElementById('sgid').checked=<?php echo (($fgmembersite->SafeDisplay('sgid')=='sgid')?'true':'false'); ?>;
document.getElementById('aaol').checked=<?php echo (($fgmembersite->SafeDisplay('aaol')=='aaol')?'true':'false'); ?>;
document.getElementById('sradr').checked=<?php echo (($fgmembersite->SafeDisplay('sradr')=='sradr')?'true':'false'); ?>;
document.getElementById('pa').checked=<?php echo (($fgmembersite->SafeDisplay('pa')=='pa')?'true':'false'); ?>;
document.getElementById('jht').checked=<?php echo (($fgmembersite->SafeDisplay('jht')=='jht')?'true':'false'); ?>;
document.getElementById('adr').checked=<?php echo (($fgmembersite->SafeDisplay('adr')=='adr')?'true':'false'); ?>;
document.getElementById('sgiid').checked=<?php echo (($fgmembersite->SafeDisplay('sgiid')=='sgiid')?'true':'false'); ?>;
document.getElementById('deoa').checked=<?php echo (($fgmembersite->SafeDisplay('deoa')=='deoa')?'true':'false'); ?>;
document.getElementById('deodep').checked=<?php echo (($fgmembersite->SafeDisplay('deodep')=='deodep')?'true':'false'); ?>;
document.getElementById('acr').checked=<?php echo (($fgmembersite->SafeDisplay('acr')=='acr')?'true':'false'); ?>;
document.getElementById('clrk').checked=<?php echo (($fgmembersite->SafeDisplay('clrk')=='clrk')?'true':'false'); ?>;
document.getElementById('scd').checked=<?php echo (($fgmembersite->SafeDisplay('scd')=='scd')?'true':'false'); ?>;
document.getElementById('sgii').checked=<?php echo (($fgmembersite->SafeDisplay('sgii')=='sgii')?'true':'false'); ?>;
document.getElementById('deoad').checked=<?php echo (($fgmembersite->SafeDisplay('deoad')=='deoad')?'true':'false'); ?>;
document.getElementById('adrd').checked=<?php echo (($fgmembersite->SafeDisplay('adrd')=='adrd')?'true':'false'); ?>;
document.getElementById('sadrd').checked=<?php echo (($fgmembersite->SafeDisplay('sadrd')=='sadrd')?'true':'false'); ?>;
document.getElementById('deob').checked=<?php echo (($fgmembersite->SafeDisplay('deob')=='deob')?'true':'false'); ?>;
document.getElementById('to').checked=<?php echo (($fgmembersite->SafeDisplay('to')=='to')?'true':'false'); ?>;
document.getElementById('jht').checked=<?php echo (($fgmembersite->SafeDisplay('jht')=='jht')?'true':'false'); ?>;
document.getElementById('mts').checked=<?php echo (($fgmembersite->SafeDisplay('mts')=='mts')?'true':'false'); ?>;





</script>


<?php

if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing',$_POST)))
 {
 	$wing=$_POST["wing"];
	$branch=$_POST["branch"];
	$section=$_POST["section"];
	$cadre=$_POST["cadre"];
	$hq=$_POST["room"];
	$cat=$_POST["cat"];
	//$nm=$_POST["nm"];

	$query="select ";
	$query.=(isset($_POST["w"])?"wng.dmn_dscrptn wing,":"");
	$query.=(isset($_POST["b"])?"brn.dmn_dscrptn branch,":"");
	$query.=(isset($_POST["s"])?"sec.dmn_dscrptn section,":"");
	$query.=(isset($_POST["c"])?"cdr.dmn_dscrptn cadre,":"");
	$query.=(isset($_POST["r"])?"ps_room_no,":"");
	$query.=(isset($_POST["ct"])?"nvl(ct.dmn_dscrptn,'not given') category,":"");
	if (isset($_POST["nm"]))
		{
    $query.="ps_nm tot,";
		}
	else
	    {
    $query.="count(ps_nm) tot,";
	    }
	$query=substr($query,0,strlen($query)-1)." ";
	$query.= "from prsnl_infrmtn_systm,estt_dmn_mstr wng,";
	$query.="estt_dmn_mstr brn,estt_dmn_mstr sec,";
	$query.="estt_dmn_mstr cdr,estt_dmn_mstr ct ";

	$query.=" where wng.dmn_id(+)=ps_wing and brn.dmn_id(+)=ps_brnch_id ";
	$query.="and  sec.dmn_id(+)=ps_sctn_id and ct.dmn_id(+)=sr_sc_st_n ";
	$query.="and cdr.dmn_id(+)=ps_cdr_id and ps_wing like '$wing' and ps_flg='W'  ";
 


    $query.="and (ps_cdr_id like 'xxyy' ";
    //New fieldset processing
	if(isset($_POST['all_desig']))
		$query.="or ps_cdr_id like '%' ";
	if (isset($_POST['pag']))
		$query.="or ps_cdr_id like 'DA00' ";
	if (isset($_POST['ag']))
		$query.="or ps_cdr_id like 'DA01' ";
	if (isset($_POST['pdc']))
		$query.="or ps_cdr_id like 'DA02' ";
	if (isset($_POST['srdag']))
		$query.="or ps_cdr_id like 'DA03' ";
	if (isset($_POST['dag']))
		$query.="or ps_cdr_id like 'DA04' ";
	if (isset($_POST['dd']))
		$query.="or ps_cdr_id like 'DA05' ";
	if (isset($_POST['wo']))
		$query.="or ps_cdr_id like 'DA07' ";


	if (isset($_POST['aag']))	$query.="or ps_cdr_id like 'DA08' ";
	if (isset($_POST['dagh']))	$query.="or ps_cdr_id like 'DA09' ";
	if (isset($_POST['dir']))	$query.="or ps_cdr_id like 'DA10' ";
	if (isset($_POST['sao']))	$query.="or ps_cdr_id like 'DB01' ";
	if (isset($_POST['saoc']))	$query.="or ps_cdr_id like 'DB02' ";
	if (isset($_POST['dm']))	$query.="or ps_cdr_id like 'DB03' ";
	if (isset($_POST['ao']))	$query.="or ps_cdr_id like 'DB04' ";
	if (isset($_POST['aoc']))	$query.="or ps_cdr_id like 'DB05' ";
	if (isset($_POST['saol']))	$query.="or ps_cdr_id like 'DB06' ";
	if (isset($_POST['sps']))	$query.="or ps_cdr_id like 'DB07' ";
	if (isset($_POST['sdp']))	$query.="or ps_cdr_id like 'DB08' ";
	if (isset($_POST['ho']))	$query.="or ps_cdr_id like 'DB09' ";
	if (isset($_POST['aao']))	$query.="or ps_cdr_id like 'DB11' ";
	if (isset($_POST['dp']))	$query.="or ps_cdr_id like 'DB12' ";
	if (isset($_POST['psec']))	$query.="or ps_cdr_id like 'DB13' ";
	if (isset($_POST['aao']))	$query.="or ps_cdr_id like 'DB14' ";
	if (isset($_POST['so']))	$query.="or ps_cdr_id like 'DB15' ";
	if (isset($_POST['aso']))	$query.="or ps_cdr_id like 'DB16' ";
	if (isset($_POST['soc']))	$query.="or ps_cdr_id like 'DB17' ";
	if (isset($_POST['spv']))	$query.="or ps_cdr_id like 'DB18' ";
	if (isset($_POST['wa']))	$query.="or ps_cdr_id like 'DB19' ";
	if (isset($_POST['sht']))	$query.="or ps_cdr_id like 'DB20' ";
	if (isset($_POST['sgi']))	$query.="or ps_cdr_id like 'DB21' ";
	if (isset($_POST['deod']))	$query.="or ps_cdr_id like 'DB22' ";


	if (isset($_POST['saodep']))	$query.="or ps_cdr_id like 'DB24' ";
	if (isset($_POST['saodepc']))	$query.="or ps_cdr_id like 'DB25' ";
	if (isset($_POST['aodep']))	$query.="or ps_cdr_id like 'DB26' ";
	if (isset($_POST['aocdep']))	$query.="or ps_cdr_id like 'DB27' ";
	if (isset($_POST['aaodep']))	$query.="or ps_cdr_id like 'DB28' ";
	if (isset($_POST['aaocdep']))	$query.="or ps_cdr_id like 'DB29' ";
	if (isset($_POST['aco']))	$query.="or ps_cdr_id like 'DB30' ";
	if (isset($_POST['acocumia']))	$query.="or ps_cdr_id like 'DB31' ";
	if (isset($_POST['fo']))	$query.="or ps_cdr_id like 'DB32' ";
	if (isset($_POST['fao']))	$query.="or ps_cdr_id like 'DB33' ";
	if (isset($_POST['rcas']))	$query.="or ps_cdr_id like 'DB34' ";
	if (isset($_POST['iao']))	$query.="or ps_cdr_id like 'DB35' ";
	if (isset($_POST['sgid']))	$query.="or ps_cdr_id like 'DB36' ";
	if (isset($_POST['aaol']))	$query.="or ps_cdr_id like 'DB37' ";
	if (isset($_POST['sradr']))	$query.="or ps_cdr_id like 'DC01' ";
	if (isset($_POST['pa']))	$query.="or ps_cdr_id like 'DC02' ";
	if (isset($_POST['jht']))	$query.="or ps_cdr_id like 'DC03' ";
	if (isset($_POST['adr']))	$query.="or ps_cdr_id like 'DC05' ";
	if (isset($_POST['sgiid']))	$query.="or ps_cdr_id like 'DC06' ";
	if (isset($_POST['deoa']))	$query.="or ps_cdr_id like 'DC07' ";
	if (isset($_POST['deodep']))	$query.="or ps_cdr_id like 'DC08' ";
	if (isset($_POST['acr']))	$query.="or ps_cdr_id like 'DC09' ";
	if (isset($_POST['clrk']))	$query.="or ps_cdr_id like 'DC10' ";
	if (isset($_POST['scd']))	$query.="or ps_cdr_id like 'DC11' ";
	if (isset($_POST['sgii']))	$query.="or ps_cdr_id like 'DC13' ";
	if (isset($_POST['deoad']))	$query.="or ps_cdr_id like 'DC14' ";
	if (isset($_POST['adrd']))	$query.="or ps_cdr_id like 'DC15' ";
	if (isset($_POST['sadrd']))	$query.="or ps_cdr_id like 'DC16' ";
	if (isset($_POST['deob']))	$query.="or ps_cdr_id like 'DC17' ";
	if (isset($_POST['to']))	$query.="or ps_cdr_id like 'DC18' ";
	if (isset($_POST['jht']))	$query.="or ps_cdr_id like 'DC19' ";
	if (isset($_POST['mts']))	$query.="or ps_cdr_id like 'DD01' ";

	//New fieldset processing
    $query.=")";

	$query.=" and ps_brnch_id like '$branch' and
              ps_sctn_id like '$section' and
              nvl(ps_room_no,'TVM') like '$hq'  and
              nvl(sr_sc_st_n,'GL') like '$cat' ";

              
     if (!(isset($_POST["nm"])))
       {
      $query.=" group by ";
      $query.=(isset($_POST["w"])?" wng.dmn_dscrptn,":"");
	  $query.=(isset($_POST["b"])?" brn.dmn_dscrptn,":"");
	  $query.=(isset($_POST["s"])?" sec.dmn_dscrptn,":"");
	  //$query.=(isset($_POST["c"])?" ps_cdr_,":"");
	  $query.=(isset($_POST["c"])?" cdr.dmn_dscrptn,":"");
	  $query.=(isset($_POST["r"])?" ps_room_no,":"");
	  $query.=(isset($_POST["ct"])?" ct.dmn_dscrptn,":"");
	  $query=substr($query,0,strlen($query)-1)." ";
       } 

      $query.=" order by ";
      $query.=(isset($_POST["w"])?" wng.dmn_dscrptn,":"");
	  $query.=(isset($_POST["b"])?" brn.dmn_dscrptn,":"");
	  $query.=(isset($_POST["s"])?" sec.dmn_dscrptn,":"");

	  $query.=(isset($_POST["r"])?" ps_room_no,":"");
	  $query.=(isset($_POST["ct"])?" ct.dmn_dscrptn,":"");
	  if (!(isset($_POST["nm"])))
	  $query.=(isset($_POST["c"])?" cdr.dmn_dscrptn,":"");
	  else
	  $query.=" ps_cdr_id,ps_nm,";
	  
	  $query=substr($query,0,strlen($query)-1)." ";

  // echo "<h1>$query</h1>";
   //store2db($query);
    echo "<table class='floatlef' id='t01'>";
    echo "<tr>";
    if (isset($_POST["w"])) echo "<th>Wing</th>";
    if (isset($_POST["b"])) echo "<th>Branch</th>";
    if (isset($_POST["s"])) echo "<th>Section</th>";
    
    if (isset($_POST["r"])) echo "<th>HQ</th>";
    if (isset($_POST["ct"])) echo "<th>Category</th>";
    if (isset($_POST["c"])) echo "<th>Designation</th>";
    if (isset($_POST["nm"])) 
    	echo "<th>Employee name</th>";
    else
    	echo "<th>Employee count</th>";
    echo "</tr>";

    $statemen=oci_parse($conn,$query);
    oci_execute($statemen);

    $wingz="";
    $branchz="";
    $sectionz="";
    $cadrez="";
    $hqz="";
    $catz="";

    while( $row=oci_fetch_array($statemen))
    	{   

    		if (isset($_POST["w"])){
    		$wingzd='';
    		if($row['WING']!=$wingz)
       			{
       		$wingzd=$row['WING'];
        	$wingz=$row['WING'];
       			}
                                    }

            if (isset($_POST["b"])){                        
       		$branchzd='';
    		if($row['BRANCH']!=$branchz)
       			{
       		$branchzd=$row['BRANCH'];
        	$branchz=$row['BRANCH'];
       			}
       								}

       		if (isset($_POST["s"])){ 						
       		$sectionzd='';
    		if($row['SECTION']!=$sectionz)
       			{
       		$sectionzd=$row['SECTION'];
        	$sectionz=$row['SECTION'];
       			}
       								}
       		
            

       		if (isset($_POST["r"])){ 						
       		$hqzd='';
    		if($row['PS_ROOM_NO']!=$hqz)
       			{
       		$hqzd=$row['PS_ROOM_NO'];
        	$hqz=$row['PS_ROOM_NO'];
       			}
       								}

       		if (isset($_POST["ct"])){ 						
       		$catzd='';
    		if($row['CATEGORY']!=$catz)
       			{
       		$catzd=$row['CATEGORY'];
        	$catz=$row['CATEGORY'];
       			}
       								}

       		if (isset($_POST["c"])){ 
       		$cadrezd='';
    		if($row['CADRE']!=$cadrez)
       			{
       		$cadrezd=$row['CADRE'];
        	$cadrez=$row['CADRE'];
       			}
       								}
    

    
    $tot=$row['TOT'];
    echo "<tr>";
    if (isset($_POST["w"])) echo "<td>$wingzd</td>";
    if (isset($_POST["b"])) echo "<td>$branchzd</td>";
    if (isset($_POST["s"])) echo "<td>$sectionzd</td>";
    
    if (isset($_POST["r"])) echo "<td>$hqzd</td>";
    if (isset($_POST["ct"])) echo "<td>$catzd</td>";
    if (isset($_POST["c"])) echo "<td>$cadrezd</td>";
    echo "<td>$tot</td>";
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


