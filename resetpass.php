<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$current_user=$fgmembersite->Userid();
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
if (!$conn)
	{
	echo 'Failed to connect to Oracle';
	die("Connection failed: " . $conn->connect_error);
	}

function test_input($data) 
	{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = htmlentities($data);
	return $data;
	}

function stripSearch($str)
    {
    $sstr=str_replace(' ', '', $str);
    return $sstr;
    }
?>



<head>
<style>
					.lg
						{
						float:left;
						width:50%;
						margin-bottom: 30px;

						}
					.bl
						{
						font-weight: bold;
						}
					.cl
					    {
					     clear:both;
					    }
					.f50
					    {
					    	width:50%;
					    }
					.f100
					    {
					    	width:98%;
					    }
					 .marglef
					 	{
					 		margin-left: 15%;
					 		margin-top: 10%;

					 	}
					 er
					    {
					 color:red;
					 font-size: 15px;
					 width:100%;
					 text-align: center;
					 float:left;
					    }
					 cor
					    {
					 color:green;
					 font-size: 15px;
					 width:100%;
					 text-align: center;
					 float:left;
					    }

					 .toolmas .tooltex
					 	{
					 visibility: hidden;
					 position: absolute;
					 background-color: black;
    				 color: #fff;
    				 text-align: center;
    				 padding: 5px 0;
    				 border-radius: 6px;
    				 z-index: 1;
					 	}
					 .toolmas:hover .tooltex
					    {
					    	visibility:visible;
					    }
					 .toolmas
					    {
					    position: relative;
    					display: inline-block;

    					}
    				 .abs
    				    {
    				    position: absolute;
    				    }

</style>
</head>

<body>
<form method="post"  class="marglef" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset class="f50 ">
<legend class="bl">Change your password here</legend>
<lab class="lg">old password</lab><ent class="lg">:<input type="text" id="oldpass" name="oldpass" class="f100"></ent>
<lab class="lg">new password</lab><ent class="lg">:<input type="text" id="newpass" name="newpass" class="f100"></ent>
<lab class="lg">hint to remember password</lab><ent class="lg">:<input type="text" id="hint" name="hint" class="f100">
</ent>
</fieldset>
<input type="submit" name="submit" value="Change"> 
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{
$query="select usr_id,pass from admin_user where usr_id='$current_user'";
//echo $query;
$statemen=oci_parse($conn,$query);
oci_execute($statemen);
if( $row=oci_fetch_array($statemen))
				{
			$psys=$row["PASS"];
				}
$puser=test_input($_POST["oldpass"]);
$npuser=test_input($_POST["newpass"]);
$hint=test_input($_POST["hint"]);
//echo "old:".$_POST["oldpass"]."new:".$_POST["newpass"];
if (stripSearch($npuser)=="")
    echo "<er>New password cant be empty</er>";
elseif ($puser!=$psys)
   echo "<er>Your old password is incorrect</er>";
else
	            {
	$query="update admin_user set pass='$npuser' where usr_id='$current_user'";
	$statemen=oci_parse($conn,$query);
    oci_execute($statemen);

    $query="update pwordhints set hint='$hint' where usr_id='$current_user'";
	$statemen=oci_parse($conn,$query);
    oci_execute($statemen);
    echo "<cor>Password Changed</cor>";
	            }
			}


?>
<div class="toolmas">

<p><a href='welcomeuser.php'> <f >Main Page</f></a></p>
            <span class="tooltex">go back</span>
</div>
</body>