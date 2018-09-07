<?PHP
require_once("./include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
    {
    $fgmembersite->RedirectToURL("login.php");
    exit;
    }
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho() );
      	if (!$conn)
        	{
        		echo 'Failed to connect to Oracle';
           		die("Connection failed: " . $conn->connect_error);
        	}
	function deluser($usr,$conn)
      {
      	//echo '1'.$usr;
      	$usr=getid($usr,$conn);
      	//echo '2'.$usr;
      	$query="delete from activeuser where idno='$usr' ";

      	$statemen=oci_parse($conn,$query);
      	oci_execute($statemen);
      }
  	function getid($nm,$conn)
        {       
          if (!$conn)
      		{
        	echo 'Failed to connect to Oracle';
          	die("Connection failed: " . $conn->connect_error);
      		}
            $query="select ps_idn from prsnl_infrmtn_systm where ps_nm like '$nm' ";
        	$statemen=oci_parse($conn,$query);
        	oci_execute($statemen);
        	if ( $row=oci_fetch_array($statemen)) return $row["PS_IDN"];
      			return $nm;
        }


$current_user=$fgmembersite->Userid();
//echo 'user'.$current_user;
//deluser($current_user,$conn);

$fgmembersite->LogOut();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Login</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>

<h2>You have logged out</h2>
<p>
<a href='login.php'>Login Again</a>
</p>

</body>
</html>