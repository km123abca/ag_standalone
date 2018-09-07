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
<?php
//echo $fgmembersite->Userrole();
?>
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


    function fillistt(rltn,typ,dest,rlget,typget)
				{
				if (rlget!='0')
					rltn=document.getElementById(rlget).value;
				if (typget!='0')
					typ=document.getElementById(typget).value;
				//console.log(rltn);
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
				xmlhttp.open("GET", "fillist.php?q=" + rltn+"&r="+ typ, true);
		    	 xmlhttp.send();
					}
				}

</script>
 <!--<link rel="STYLESHEET" type="text/css" href="maindb3.css" /> -->
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
                            .purple
                			{
                			background-color: #f0f8ff;
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

<h1 id="offheading">  Office of the Accountant General, Thiruvananthapuram</h1>
</head>
 

<body id="bodyora" class="purple">

<form method="post" action="displayHelper.php" >
<!--<fieldset>-->


<fieldset>
<legend>All employees from all wings</legend>

  <f class="lg bl">Wing</f>   <inp class="lg">:<select id="wing1" name="wing1" onchange="wingchanged(this.value)"  >
          <option value='%' selected>-------</option>
	      <option value='W01'>GSSA</option>
	      <option value='W11'>ERSA</option>
	      <option value='W21'>PD Central</option>
	      </select></inp>
	     
       <script>
        fillistt('%','03','branch','0','0');
        fillistt('%','17','section','0','0');
 	    fillistt('%','01','cadre','0','0');
     </script>                                       
     
     <f class="lg bl">Branch</f> <inp class="lg">:<select id="branch" name="branch" onchange="branchchanged(this.value)"  >
          <option value='%' selected>--------------------</option>
	      </select></inp>

	 <f class="lg bl">Designation</f><inp class="lg">:<select id="cadre" name="cadre"  >
          <option value='%' selected>--------------------</option>
	      </select></inp>
		  
      <f class="lg bl">Section</f><inp class="lg">:<select id="section" name="section"  >
          <option value='%' selected>--------------------</option>
		  </select></inp>
		  
           <f class="lg bl">Location</f><inp class="lg">:<select id="loc" name="loc" >
           <option value='%' selected>--------------------</option>
           <option value='KDE'>Kozhikode</option>
		   <option value='EKM'>Ernakulam</option>
		   <option value='KTM'>Kottayam</option>
		   <option value='TCR'>Thrissur</option>
		   <option value='TVM'>Thiruvananthapuram</option>
		   </select></inp>
		   
 
 
 </fieldset>
  <input type="submit" name="submit" value="Generate">
 <!--</fieldset>-->
 </form>
<a href='welcomeuser.php'> Back to Main Page</a>
 <fieldset>
 <legend> Other Reports </legend>
 	<pre>

 	<a href="employeefulllist.php">All Employee details</a>
 	<a href="section_history.php">Section History</a>
 	<a href='countorarepo_v3.php'>Employee Count</a>
 	<a href="combinedcadres.php">Staff Position cadre group wise including deputation</a>
 	<a href="combinedcadres_nodepo.php">Staff Position cadre group wise excluding deputation</a>
 	<a href="staff_position.php">Staff Position Status in GSSA</a>
 	<a href="staff_position_ersa.php">Staff Position Status in ERSA</a>
 	<a href="staff_position_pdc.php">Staff Position Status in PDC</a>
 	<a href="z1orarepo_v3.php">Employees due for retirement</a>  
 	<a href="joiningwise.php">Employees who joined between specific dates</a> 
 	<a href="counter.php">User Specified Report for employee count</a>
 	<a href="detailer.php">User Specified Report for employee details</a>

 	
 	</pre>
 </fieldset>
</body>