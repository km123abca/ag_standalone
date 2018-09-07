<?php 
function getlink()
	{
		$lin='#';
		if (isset($_REQUEST['linn'])) 
		$lin=$_REQUEST['linn'];
		if ($lin=='#')
		$linna="<a href='$lin' target='blank'>attachment</a>";
		else
		$linna="<a href='$lin' target='blank'>No attachment</a>";
		return $linna;
	}

?>

<head>
<script>
		function nshow()
			{
				document.querySelector('div').style.display='none';
			}
		function showw()
			{
				document.querySelector('div').style.display='block';
			}
</script>
</head>


<body   <?php
		 //if (!(isset($_FILES["fileToUpload"])))
		echo "onbeforeunload=\"nshow()\" ";
	   
		?>
>
<div style='width:300px;height: 200px;background-color:#120012;'></div>
<form action="fileuploadt.php" method="post" enctype="multipart/form-data">
<input type="file" name="fileToUpload" id="fileToUpload" class='labtdx' >
<input type="submit" value="Upload" name="submit" class='labtdx'>
<br>
<?php
echo getlink();
?>
</form>
<br><button type='button' onclick='showw()'>show</button>
<br><button type='button' onclick='nshow()'>hide</button>
</body>