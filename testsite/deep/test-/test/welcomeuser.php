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
	*
	{
    box-sizing: border-box;
	}
	.purple
	{
	background-color:  #e6e6fa;
	}
	.colcont
	{
	width:100%;
	height: 100%;
	position: absolute;
	float:left;
	
	}
	.coltab
	{
    width:100%;
    height: 50%;
    position: relative;
	float:left;
    }
	h1
	{
	position: relative;
	margin-left:10%;
	margin-right:10%;
	font-size: 48px;

	}
	#i1
		{
	position: relative;
    width:100%;
    border:3px solid black;
    font-size: 40px;
    background-color: #00ffff;
    /*margin-left: 26%;*/
		}
	a:hover
		{
    background-color: #f0f8ff;
		}	
	</style>
<h1 ">Office of the Accountant General ,Trivandrum</h1>
</head>


<body class="purple">

<!--
<c1 class="colcont" >
<c2 class="coltab" style="background-color: gray;"></c2>
<c2 class="coltab" style="background-color: yellow;"></c2>
</c1>
-->

<pre id="i1">
<a href="maindb3.php">Personal Information System</a>
<a href="orarepo_v3.php">Reports</a>
<a href="querymasterbasic.php">querymaster</a>
<a href="payslipgen.php">Payslip</a>
<a href="leaveapplicationform.php">Apply for Leave</a>
<?php if ($fgmembersite->Userrole()!='basic')
echo "<a href='leaveapprover.php'>Approve Leave (Admin only)</a><br>";
?>
<a href="photoviewer.php?m=1">photos</a>
<a href="resetpass.php">reset password</a>
<a href='logout.php'> <f>Logout</f></a>
</pre>

</body>