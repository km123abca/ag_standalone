<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
function getsel($str)
      {
        $disp='';
      if (isset($_POST["wing"]))
         {
          $disp=($str==($_POST["wing"]))?'selected':'';
         }
      return $disp;
      }
?>
<head>

<h1 id="hea2">   </h1>

<style>
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
              #hea2
              {
              text-align: center;
              float:left;
              width:100%;
                        font-weight: bold;
                        background-color:#eee; 
              }

              button
              {
              background-color: black;
              color:white;
              border:none;
              font-weight: bold;
              width:100%;
              cursor: pointer;
             }
 </style>
<script >
 function rearrange(str)
  {   
            
      window.location.href="malefemale.php?ord="+str;
  }
 
  function makelistt(rltn,typ,dest)
        {
        
        if (rltn.length!=0)
          {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function()
            {
          if (this.readyState == 4 && this.status == 200)
              {    //console.log('The resposeText received is this '+this.responseText);
            document.getElementById(dest).innerHTML="";
            document.getElementById(dest).innerHTML+=this.responseText;
              }
            };
        xmlhttp.open("GET", "interfere.php?q=" + rltn+"&n="+ typ+"&dest="+ dest, true);
           xmlhttp.send();
          }
        }

  
  </script>

</head>


<body>

<script>
document.getElementById("hea2").innerHTML=' Male/Female division among employees ';
makelistt('%','01','cadre');
</script>

<a href="index.php" >back to main page</a>
    <fieldset>

    <legend>Select an Office</legend>
    <form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Office:<select id="wing" name="wing"            
           >  
          <option value='%' <?php echo getsel('%');?> >select all</option>
        <option value='W01' <?php echo getsel('W01');?>>GSSA</option>
        <option value='W11' <?php echo getsel('W11');?>>ERSA</option>
        <option value='W21' <?php echo getsel('W21');?>>PD Central</option>
        </select>
  Designation:<select id="cadre" name="cadre"   
              >   
              <option value='%' >select all</option>
                </select>
        
  <input type="submit" name="list" id="subut" > 
    </form>
    </fieldset>

<form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="stab">
<tr> 
    <th><button type="button" onclick="rearrange('cd')">Designation</button></th> 
    <th><button type="button" onclick="rearrange('p1')">         Male        </button></th> 
    <th><button type="button" onclick="rearrange('p2')">         Female        </button></th> 
    <th><button type="button" onclick="rearrange('p3')">         Sum        </button></th>    
 </tr>
<?php
//session_start();
//$_SESSION["toggle"]='desc';

//if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wing',$_POST)))
{
  //$wing=isset($_REQUEST["wing"])?$_REQUEST["wing"]:'%';
  //$cadre=isset($_REQUEST["cd"])?$_REQUEST["cd"]:'%';
    //if(!(isset($_REQUEST["wing"])))   
       if (isset($_REQUEST["ord"]))
          {
          $wing=$_SESSION['mfwing'];
          $cadre=$_SESSION['mfcadre']; 
          }  
       else if (isset($_POST["wing"]))
          {
          $wing=isset($_POST["wing"])?$_POST["wing"]:'%';
          $cadre=isset($_POST["cadre"])?$_POST["cadre"]:'%';
          $_SESSION['mfwing']=$wing;
          $_SESSION['mfcadre']=$cadre;
          }
      
       else
          {
           $wing='%';
           $cadre='%';
           $_SESSION['mfwing']=$wing;
           $_SESSION['mfcadre']=$cadre; 
          }
$query="select cd,dmn_dscrptn cadre,nvl(c1,0) male,nvl(c2,0) female,nvl(c3,0)  total 
            from
            (select distinct ps_cdr_id cd from prsnl_infrmtn_systm 
             where   ps_cdr_id like '$cadre'
            ) aa,

            (select ps_cdr_id cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where 
                    ps_sx_typ='M' and ps_flg='W' and ps_wing like '$wing'
                    group by ps_cdr_id)a,

			      (select ps_cdr_id cd2,count(ps_cdr_id) c2 
					          from prsnl_infrmtn_systm where 
 					          ps_sx_typ='F' and ps_flg='W' and ps_wing like '$wing'
					          group by ps_cdr_id) b,
			      (select ps_cdr_id cd3,count(ps_cdr_id) c3 
					          from prsnl_infrmtn_systm where 
 					          ps_flg='W' and ps_wing like '$wing'
					          group by ps_cdr_id) c,
      			estt_dmn_mstr 
		    where dmn_id(+)=cd and
              cd=cd1(+) and 
              cd=cd2(+) and 
              cd=cd3(+) ";

$ord=" order by cd";
$ordparam='cd';
if(isset($_REQUEST["ord"])) $ordparam=$_REQUEST["ord"];
$ordar=array('p1'=>'c1','p2'=>'c2','p3'=>'c3','cd'=>'cd');
$ordparam=$ordar[$ordparam];

    if (!isset($_SESSION['toggle'])) $_SESSION['toggle']='';
    if ($_SESSION['toggle']!='desc') $_SESSION['toggle']='desc';
    else $_SESSION['toggle']='';

$ord=" order by nvl($ordparam,0) ".$_SESSION['toggle'];
$query.=$ord;


 
 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 while( $row=oci_fetch_array($statemen))
 	{
 $cadre=$row["CADRE"];
 if($cadre=='')continue;
 $m=$row["MALE"];
 $f=$row["FEMALE"]; 
 $sum=$row["TOTAL"];
 //echo 'the session variable is now:'.$_SESSION['toggle'];
 echo "<tr> 
       <td>$cadre</td> 
       <td>$m</td>
       <td>$f</td> 
       <td>$sum</td> 
        </tr>";
	}

}
?>
</table>
</form>


</body>