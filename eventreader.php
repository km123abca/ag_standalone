<head>
		<style>
					 
					#hea2
							{
							text-align: center;
							float:left;
							width:100%;
                    		font-weight: bold;
                    		 background-color:#efe;
							}
					body
							{
							/*background-color:#eee;	*/
							background-image:url("images/1120.jpg");
							background-size: cover;
							background-position: center;
							background-repeat: no-repeat;
							height: 100%; 
							}
					 
					
		</style>
		<script>
		function slowdown()
			{

				//alert(document.getElementById('mq').scrollAmount);
				var marquee = document.getElementById ("mq");
            	//var input = document.getElementById ("myInput");

            marquee.scrollAmount = 20;
				//document.getElementById("mq").scrollAmount=20;
			}
		</script>
		<h1 id="hea2">Important Events at O/o AG (GSSA) during <?php echo date("m/y");?></h1>
</head>



<body>
<marquee  scrollamount='10' vspace="100" id="mq" onmouseover="slowdown();"
         style="background-color:black;font-size: 36;color:white;font-weight: bold;"  >
<?php
$events_file=file("events.txt",FILE_IGNORE_NEW_LINES);

foreach ($events_file as $line)
 echo  "$line..........";
//fclose($events_file);
?>
</marquee>
</body>