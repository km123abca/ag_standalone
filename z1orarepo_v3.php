<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>
<head>


<!--  ALIEN CONTENT FOR CALENDER ADDED BY KRISHNAMOHAN  -->

	                <link href="outsidecss/jquery.datepick.css" rel="stylesheet">
					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
					<script src="outsidejs/jquery.plugin.min.js"></script>
					<script src="outsidejs/jquery.datepick.js"></script>
					<script>
						$(function() {
						$('#sdate').datepick({dateFormat:'dd/mm/yyyy'});
						$('#edate').datepick({dateFormat:'dd/mm/yyyy'});
						$('#inlineDatepicker').datepick({onSelect: showDate});
									  });

						function showDate(date) {
									alert('The date chosen is ' + date);
												}
					</script>

                    <!--  ALIEN CONTENT ENDS HERE  -->
<script>

function proc()
	{
	document.getElementById("sp").innerHTML=document.getElementById("wing").value;
	}
	
function adop()
	{
		document.getElementById("wing").innerHTML= document.getElementById("wing").innerHTML +"<option value='W31'>GSSA TRICHUR</option>";
	}
	
function wingchanged(str)
	{
		//document.getElementById("wing").value=document.getElementById("wing1").value;
		
		if (str.length!=0)
			{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
				{
		if (this.readyState == 4 && this.status == 200)
					{    //console.log('The resposeText received is this '+this.responseText);
		document.getElementById("branch").innerHTML=this.responseText;
					}
				};
				
		xmlhttp.open("GET", "interfere.php?q=" + str+'&n=03', true);
		//console.log(str);
        xmlhttp.send();
			}
	}
	
function branchchanged(str)
	{
		//document.getElementById("wing").value=document.getElementById("wing1").value;
		
		if (str.length!=0)
			{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
				{
		if (this.readyState == 4 && this.status == 200)
					{   // console.log('The resposeText received is this '+this.responseText);
		document.getElementById("section").innerHTML=this.responseText;
					}
				};
		xmlhttp.open("GET", "interfere.php?q=" + str+'&n=%', true);
		//console.log(str);
        xmlhttp.send();
			}
	}
	
function finalexec()
	{
		var wing=document.getElementById("wing1").value;
		var branch=document.getElementById("branch").value;
		var section=document.getElementById("section").value;
		var location=document.getElementById("loc").value;
		var str=wing+','+branch+','+section+','+location;
		console.log(str);
		if (!((wing=="")||(branch=="")||(section=="")||(location=="")))
			{
		window.location.href="findis.php?q="+str;
			}
		else
			{
		alert('Some boxes are empty');
			}
		
	}


</script>

<style>
	<style >
						*
 							{word-wrap:break-word;
 							 box-sizing:border-box;

 							}
						#i1
							{
							position: relative;
    						left:30%;
    						top:20%;
    						width:100%x;
    						/*height:300px;*/
    						border:3px solid white;
    						font-size: 20px;
    						background-color: #00ffff;
							}
						f
							{
							position: relative;
							float:left;
							}
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

						.bl,legend
							{
							font-weight: bold;
							}
						#branch,#wing1,#cadre,#section,#loc
							{
							width:50%;
							}
						legend
							{
							color:blue;
							}
</style>

</style>
<h1 id="offheading">  Persons due for retirement</h1>
</head>
 

<body>

<form method="post" action="z1displayHelper.php">
<fieldset>

  <?php  
		//echo $fgmembersite->SafeDisplay('wing');
		$selstrs=array('%'=>'selected','W01'=>'','W11'=>'','W21'=>'');
		$wingsel=$fgmembersite->SafeDisplay('wing1');
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

  <f class="lg bl">Wing</f>   <inp class="lg">:<select id="wing1" name="wing1" onchange="wingchanged(this.value)"  >
          <option value='%' <?php  echo $selstrs['%'];  ?>>-------------</option>
	      <option value='W01'  <?php  echo $selstrs['W01'];  ?> >GSSA</option>
	      <option value='W11'  <?php  echo $selstrs['W11'];  ?> >ERSA</option>
	      <option value='W21'  <?php  echo $selstrs['W21'];  ?>  >PD Central</option>
	      </select></inp>
                                               <!--          unnecessary          <input type="text" id="wing" name="wing" style="visibility:hidden;">   -->
     <f class="lg bl">Branch</f> <inp class="lg">:<select id="branch" name="branch" onchange="branchchanged(this.value)" >
          <option value='%' selected>--------------------</option>
	      </select></inp>
		  
      <f class="lg bl">Section</f><inp class="lg">:<select id="section" name="section"  >
          <option value='%' selected>--------------------</option>
		  </select></inp>
		  
      <f class="lg bl">Location</f><inp class="lg">:<select id="loc" name="loc">
           <option value='%' selected>--------------------</option>
           <option value='KDE'>Kozhikode</option>
		   <option value='EKM'>Ernakulam</option>
		   <option value='KTM'>Kottayam</option>
		   <option value='TCR'>Thrissur</option>
		   <option value='TVM'>Thiruvananthapuram</option>
		   </select></inp>

	    <f class="lg bl">start date</f><inp class="lg">:<input type='text' name='sdate' id='sdate' placeholder="DD/MM/YY"></inp>
	    <f class="lg bl">end date</f><inp class="lg">:<input type='text' name='edate'  id='edate' placeholder="DD/MM/YY"></inp>
		   
 <input type="submit" name="submit" value="Generate"> 
 
 </fieldset>
 </form>
 <a href="index.php">Go back to Main Menu</a>

 
</body>