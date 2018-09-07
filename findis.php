<head>
<style>

    table, th, td 
	{
    border: 1px solid black;
     text-align: right;
     border-collapse: collapse;
     
    }
    tr:hover {background-color: #f5f5f5;}
    tr:nth-child(even) {background-color: #f2f2f2;}
    th {
    background-color: #4CAF50;
    color: white;
    }
	
	
	body
	{
	background-image:url('plants.jpg');
	}
	#inrow
	{
	background-color:yellow;
	}
	ee
	{
	background-color:yellow;
	}
</style>
  

</head>

<script>
function rearrange(str)
	{
		//document.getElementById("wing").value=document.getElementById("wing1").value;
		
		if (str.length!=0)
			{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
				{
		if (this.readyState == 4 && this.status == 200)
					{    //console.log('The resposeText received is this '+this.responseText);
	    var headerText="<tr>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_idn')\">Office Id</button> </th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_nm')\">Name </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_floor')\">Level </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_sctn_id')\">Section </button></th>"+
	    				"<th><button type=\"button\" onclick=\"rearrange('ps_wing')\">Wing </button></th>"+
	    				"</tr>";
		document.getElementById("inrow").innerHTML=headerText+this.responseText;
					}
				};
				
		xmlhttp.open("GET", "orarepo_v2_helper.php?q=" + str, true);
		//console.log(str);
        xmlhttp.send();
			}
	}
</script>
<body  >
<table id="inrow" >
	<tr>
		<th>Office Id </th>
		<th>Name </th>
		<th>Level </th>
		<th>Section</th>
		<th>Wing </th>
	</tr>
	


<?php
    if (isset($_REQUEST["q"]))
	{

	$q = $_REQUEST["q"];
	$paras=explode(',',$q);
	//var_dump($paras);
	if(array_key_exists(0, $paras))
		{
	$wing=$paras[0];
	$section=$paras[2];
	$branch=$paras[1];
	$location=$paras[3];
		}
    }
	$query="select ps_idn idd,ps_nm namee,ps_floor levell,sec.dmn_dscrptn sectionn,wng.dmn_dscrptn wingg  from prsnl_infrmtn_systm a,estt_dmn_mstr sec,estt_dmn_mstr wng
			where ps_sctn_id=sec.dmn_id(+) and ps_wing=wng.dmn_id(+)  
			and ps_wing like '$wing' and 
			   ps_sctn_id like '$section' and 
			   ps_brnch_id like '$branch' and 
			   nvl(ps_room_no,'0') like '$location'";
			//echo '<ee>'.$query.'</ee>';
			 
	$conn=oci_connect("km","rt","localhost/test2");
	if (!$conn)
		{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
		}
	$statemen=oci_parse($conn,$query);
	oci_execute($statemen);
	while($row=oci_fetch_array($statemen))
		{
	$psidn=$row["IDD"];
	$psnm=$row["NAMEE"];
	$psfloor=$row["LEVELL"];
	$sect=$row["SECTIONN"];
    $wng=$row["WINGG"];	
	
	echo  "
		  <tr>
		  <td>$psidn</td>
		  <td>$psnm</td>
		  <td>$psfloor</td>
		  <td>$sect</td>
		  <td>$wng</td>
		  </tr>
		 ";
		   
	      
		 
	    }
			
?>
</table>        
</body>


