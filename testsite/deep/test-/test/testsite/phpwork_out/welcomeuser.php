<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>
<head>
	<style>
	h1
	{
	position: relative;
	left:23%;
	font-size: 48px;

	}
	#i1
		{
	position: relative;
    left:30%;
    top:20%;
    width:700px;
    height:300px;
    border:3px solid black;
    font-size: 40px;
    background-color: #00ffff;
		}
	a:hover
		{
    background-color: #4CAF50;
		}	
	</style>
<h1>Office of the Accountant General ,Trivandrum</h1>
</head>


<body>

<pre id="i1">
<a href="maindb3.php">Personal Information System</a>
<a href="orarepo_v3.php">Reports</a>
<a href="querymasterbasic.php">querymaster</a>
<a href="payslipgen.php">Payslip</a>
<a href="photoviewerhead.php">photos</a>
<a href='logout.php'> <f>Logout</f></a>
</pre>

</body>