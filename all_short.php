

<head>
	<style>
	#sea,#ima
	{
		width:30%;
		position: relative;
		float: left;

	}
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

	/*Added on 12 June 2018 */
	table#stab 
              {
                width: 100%; 
                background-color: #f1f1c1;
              }
              th
              {
              text-align: left;
              }
              table#stab tr:nth-child(even) 
              {
                background-color: #eee;
              }
              table#stab tr:nth-child(odd) 
              {
                background-color: #fff;
              }
              table#stab th 
              {
                color: white;
                background-color: black;
              }
	/*Added on 12 June 2018 */


    /*Added on 29 June 2018 */
	          body
	          {
	          	background-color: #bec5d1; 
	          }

	  /*Added on 29 June 2018 */
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

<!-- Jquery script added on 12 June 2018-->
<script src="outsidejs/jq.js"></script>
<script>
$(document).ready(
                  function()
                  {
                  $("#fs").on("keyup", function() {
                                                        var value = $(this).val().toLowerCase();
                                                        $("#tablebody tr").filter(
                                                                                function() {
                                                                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                                                                            }
                                                                                );
                                                        }
                                  );

                    }
                  );
</script> 
<!-- Jquery script added on 12 June 2018-->


</head>


<body>










<?php
			
			
			
			 echo '<br>';
			 echo "<img id='ima' src='.\images\\".'point'.".png' alt='no photo' style='width:100px;height:122px;'>";
             echo '<div id=\'sea\'>Type any part of whatever you need to search here:<input type=\'text\' id=\'fs\'></div>';
   			 echo '<br>';	
			
			$conn=oci_connect('ags','ags','localhost/xe');


			$query="select ps_nm name,
						   decode(ps_flg,'W','Present','Left office') status,
						   --ps_idn office_id,
						   sec.dmn_dscrptn section,
						   --wng.dmn_dscrptn wing,
						   cd.dmn_dscrptn designation--,
						   --'photo' photo
					from 
						   prsnl_infrmtn_systm,estt_dmn_mstr sec,estt_dmn_mstr wng,estt_dmn_mstr cd 
					where 
						    ps_wing=wng.dmn_id(+) and ps_sctn_id=sec.dmn_id(+) and ps_cdr_id=cd.dmn_id(+)  
					order  
					       by ps_wing,ps_cdr_id,ps_nm";


			// $_SESSION["curquery"]=$query;
			$statemen=oci_parse($conn,$query);
			oci_execute($statemen);
			$firstrow=True;

			echo '<table id=\'stab\'>';
			while ($row = oci_fetch_array($statemen))
				{   $rowsel=0;
					if ($firstrow)
					{
					echo '<thead>';
					echo '<tr>';
					foreach($row as $key=>$val)
						{
					$rowsel+=1;
					if (($rowsel%2)==0)									
                    echo '<th>'.$key.'</th>';
                    	}				
					echo '</tr>';
					echo '</thead>';
					echo '<tbody id=\'tablebody\'>';
				    }  
				    $firstrow=False;
				    $rowsel=0;
				    echo '<tr>';
					foreach($row as $key=>$val)	
						{	
					$rowsel+=1;		
					if (($rowsel%2)==0)	
							{		
				    if ($key=='PHOTO')
				    	$val="<img src='.\photo_cag\\".$empid.".jpg' alt='no photo' style='width:100px;height:122px;'>";	
				    else if ($key=='OFFICE_ID') $empid=$val;		
                    echo '<td>'.$val.'</td>';
                    		}
                    	}				
					echo '</tr>';		
					
				}
			echo '</tbody></table>';
			
?>



</body>