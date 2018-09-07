<head>

	<script>
	function redirect()
		{
    window.location.href="welcomeuser.php";
		}
	</script>
	<style>
	#mm
	  {
	  	
	  	left: 40%;
	  	top:30%;
	  	position:relative;
	  	left :30%;
	  	
	  	
	  }
	  button
	  {
	  	position: relative;
	  	left: 20%;
	  }
	  #mess
	  { 
	  	font-size: 28px;
	  	font-weight: bold;
	  }
	</style>
</head>

<body>
     <box1 id="mm">
    <b1 id="mess">You dont have sufficient privileges to view the page you clicked on</b1><br>
	<button type="button" onclick="redirect()">Back to where I came from</button>
	</box1>
</body>