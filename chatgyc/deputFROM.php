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
             #redtab
             {
             	background-color: red;
             }
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
            
      window.location.href="deputFROM.php?ord="+str;
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
document.getElementById("hea2").innerHTML=' Employees who went on deputation from this office';
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
    <th><button type="button" >SL No. </button></th> 
    <th><button type="button" onclick="rearrange('p0')">Name and Designation</button></th> 
    <th><button type="button" onclick="rearrange('p1')">HQ</button></th> 
    <th><button type="button" onclick="rearrange('p2')">Deputed to</button></th> 
    <th><button type="button" onclick="rearrange('p3')">Start Date</button></th>
    <th><button type="button" onclick="rearrange('p4')">Sanctioned till</button></th>
    <th><button type="button" >Remarks </button></th>    
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
$query="select ps_nm||','||cdr.dmn_dscrptn nd,
               nvl(ps_room_no,'TVM') hq,
               b.dmn_dscrptn place,
               PS_DPTTN_FRM_DT frd,
               PS_DPTTN_TO_DT ttd,
               to_char(PS_DPTTN_TO_DT,'dd-mm-yyyy') ttd2,
               ' ' remarks
from   prsnl_infrmtn_systm a,
       estt_dmn_mstr b,
       estt_dmn_mstr cdr,estt_dmn_mstr stat 
where  cm_clms_flg in ('F10','F12','F04') and b.dmn_id(+)=ps_dpttn_place
and    cdr.dmn_id(+)=ps_cdr_id and stat.dmn_id(+)=cm_clms_flg
 ";

$ord=" order by ps_cdr_id";
$ordparam='p0';
if(isset($_REQUEST["ord"])) $ordparam=$_REQUEST["ord"];
$ordar=array('p0'=>"ps_cdr_id||','||ps_nm",
             'p1'=>"nvl(ps_room_no,'TVM')",
             'p2'=>'b.dmn_dscrptn',
             'p3'=>'PS_DPTTN_FRM_DT',
             'p4'=>'PS_DPTTN_TO_DT'
             );
$ordparam=$ordar[$ordparam];

    if (!isset($_SESSION['toggle'])) $_SESSION['toggle']='';
    if ($_SESSION['toggle']!='desc') $_SESSION['toggle']='desc';
    else $_SESSION['toggle']='';

$ord=" order by nvl($ordparam,0) ".$_SESSION['toggle'];
$query.=$ord;


 
 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 $sl=0;
 while( $row=oci_fetch_array($statemen))
 	{
 $sl+=1;
 $cadre=$row["ND"];
 $hq=$row["HQ"];
 $place=$row["PLACE"]; 
 $frd=$row["FRD"];
 $ttd=$row["TTD"]; 
 $remarks=$row["REMARKS"];

 $dt=$row["TTD2"];
 $dtcurr=date("d-m-Y");
 $dtyr=substr($dtcurr, strlen($dt)-4,4);
 $dtres=substr($dt, 0,strlen($dt)-4);
 $dttoprocess=$dtres.$dtyr;
 $diff = (strtotime($dttoprocess) - strtotime($dtcurr))/86400;
 if ($diff<0) $diff=1000;
 $styledif='';
 if ($diff<5)
 	$styledif="style='background-color:red'";

 //echo 'the session variable is now:'.$_SESSION['toggle'];
 echo "<tr $styledif> 
       <td>$sl</td>
       <td>$cadre</td> 
       <td>$hq</td>
       <td>$place</td> 
       <td>$frd</td>
       <td>$ttd</td> 
       <td>$remarks</td> 
        </tr>";
	}

}
?>
</table>
</form>


</body>