<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
function getsel($str)
      {
        $disp='';$poswing='n';$seswing='n';
        if (isset($_POST['wing'])) $poswing=$_POST['wing'];
        if (isset($_SESSION['mfwing'])) $seswing=$_SESSION['mfwing'];
        (($seswing!='%')&&($poswing=='%'))?$poswing=$seswing:$seswing='n';
        $disp=($str==$poswing)?'selected':'';
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
            
      window.location.href="differentlyabled.php?ord="+str;
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
document.getElementById("hea2").innerHTML=' Catergory wise division among employees ';
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
    <th><button type="button" onclick="rearrange('p1')">Office</button></th> 
    <th><button type="button" onclick="rearrange('p2')">Wing</button></th>
    <th><button type="button" onclick="rearrange('p3')">Designation</button></th> 
    <th><button type="button" onclick="rearrange('p4')">Name</button></th> 
    <th><button type="button" onclick="rearrange('p5')">Section</button></th>
    <th><button type="button" onclick="rearrange('p6')">disability </button></th>    
 </tr>
<?php
$ordar=array('p1'=>'wng.dmn_dscrptn',
             'p2'=>'brn.dmn_dscrptn',
             'p3'=>'ps_cdr_id',
             'p4'=>'ps_nm',
             'p5'=>'sct.dmn_dscrptn',
             'p6'=>'ps_ph_dtls'
            );
if (!(isset($_SESSION['mfwing']))) $_SESSION['mfwing']='%';
if (!(isset($_SESSION['mfcadre']))) $_SESSION['mfcadre']='%';
   
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
$query="select ps_nm,cdr.dmn_dscrptn cadre,wng.dmn_dscrptn wing,brn.dmn_dscrptn branch,
               sct.dmn_dscrptn sectionn, 
               decode(ps_ph_dtls,'OH','Ortopaedically Handicapped'
                                ,'HH','Hearing Handicapped'
                                ,'VH','Visually Handicapped','Unknown Handicap') det
        from 
        prsnl_infrmtn_systm a,estt_dmn_mstr cdr,estt_dmn_mstr wng,estt_dmn_mstr brn,estt_dmn_mstr sct
        where
        ps_cdr_id=cdr.dmn_id(+) and ps_wing=wng.dmn_id(+) and ps_brnch_id=brn.dmn_id(+) and
        ps_sctn_id=sct.dmn_id(+) and ps_flg='W' and ps_ph_stts='Y'
        and ps_wing like '$wing' and ps_cdr_id like  '$cadre'";

$ord=" order by wng.dmn_dscrptn,brn.dmn_dscrptn,ps_cdr_id";
$ordparam='cd';
if(isset($_REQUEST["ord"])) 
    {
    $ordparam=$_REQUEST["ord"];
    $ordparam=$ordar[$ordparam];
    if (!isset($_SESSION['toggle'])) $_SESSION['toggle']='';
    if ($_SESSION['toggle']!='desc') $_SESSION['toggle']='desc';
    else $_SESSION['toggle']='';
    $ord=" order by nvl($ordparam,'0') ".$_SESSION['toggle'];
    }
$query.=$ord;


 
 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 $nmp='n';$cdrp='n';$wingp='n';$branchp='n';$sectionp='n';$detp='n';
 while( $row=oci_fetch_array($statemen))
 	{
 $nm=$row['PS_NM'];
 $cdr=$row['CADRE'];
 $wing=$row['WING'];
 $branch=$row['BRANCH'];
 $section=$row['SECTIONN'];
 $det=$row['DET'];
 ($wing!=$wingp)?$wingp=$wing:$wing='';
 ($branch!=$branchp)?$branchp=$branch:$branch='';
 ($cdr!=$cdrp)?$cdrp=$cdr:$cdr='';
 
 echo "<tr> 
       <td>$wing</td> 
       <td>$branch</td>
       <td>$cdr</td> 
       <td>$nm</td>
       <td>$section</td> 
       <td>$det</td> 
        </tr>";
	}


?>
</table>
</form>


</body>