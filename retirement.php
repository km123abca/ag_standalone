<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
function getsel($str)
      {
        $disp='';
      if (isset($_POST["wing"]))
         {
          $disp=($str==($_POST["wing"]))?'selected':'';
         }
      return $disp;
      }

function cleaan($desc,$conn)
      { 
        if ($desc=='%') return $desc;        
        $desc=strtoupper($desc); 
          if (!$conn)
      {
        echo 'Failed to connect to Oracle';
          die("Connection failed: " . $conn->connect_error);
      }
        $query="select dmn_id from estt_dmn_mstr where 
                dmn_dscrptn like"." '$desc'";
  
        $statemen=oci_parse($conn,$query);
        oci_execute($statemen);
        if ( $row=oci_fetch_array($statemen))
        {   //echo $row["DMN_ID"];

      return $row["DMN_ID"];
          }
     
        return $desc;
      }

  function descr($dmnid,$conn)
      { 
        if ($dmnid=='%') return $dmnid;
      $dmnid=strtoupper($dmnid); 
        if (!$conn)
      {
        echo 'Failed to connect to Oracle';
          die("Connection failed: " . $conn->connect_error);
      }
      $query="select dmn_dscrptn from estt_dmn_mstr where 
                dmn_id like"." '$dmnid'";
      $statemen=oci_parse($conn,$query);
      oci_execute($statemen);
      if ( $row=oci_fetch_array($statemen))
        {   
      return $row["DMN_DSCRPTN"];
          }
      return 'Not Given';
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

function fillvals(str,val,tval='none')
  {
    if (tval=='none')
    document.getElementById(str).value=val;
    else
      {
      document.getElementById(str).innerHTML="<option value='"+val+"'>"+tval+"</option>"+document.getElementById(str).innerHTML;
      }
      console.log( document.getElementById(str).innerHTML);
  }

function fixval(str,val)
    {   
    var svar=document.getElementById(str).innerHTML;
     console.log(svar);
    var svarArr=svar.split('<option');
    var bigstr="";
    for (var elem in svarArr )
        {
          var lin=svarArr[elem];
          var fispos=svarArr[elem].indexOf("\"");
          var secpos=svarArr[elem].indexOf("\"",fispos+1);
          var val2search=lin.substring(fispos+1,secpos);
          
          if (secpos<2) continue;
          if (val2search==val)
           bigstr+= "<option"+lin.substring(0,secpos)+"\" selected"+lin.substring(secpos+1,lin.length-1);
           else
           bigstr+="<option"+lin.substring(0,secpos)+"\" "+lin.substring(secpos+1,lin.length-1);
        
        }
        document.getElementById(str).innerHTML=bigstr;
       
      
    }

 function rearrange(str)
  {   
            
      window.location.href="retirement.php?ord="+str;
  }
 
  function makelistt(rltn,typ,dest,defval='none')
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
        xmlhttp.open("GET", "interfere.php?q=" + rltn+"&n="+ typ+"&dest="+ dest+"&defval="+ defval, true);
           xmlhttp.send();
          }
        }

  
  </script>

  <!--  ALIEN CONTENT FOR CALENDER ADDED BY KRISHNAMOHAN  -->

                  <link href="outsidecss/jquery.datepick.css" rel="stylesheet">
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
          <script src="outsidejs/jquery.plugin.min.js"></script>
          <script src="outsidejs/jquery.datepick.js"></script>
          <script>
            $(function() {
            $('#sdate').datepick({dateFormat:'dd/mm/yyyy'});
            $('#edate').datepick({dateFormat:'dd/mm/yyyy'});
            $('#inlineDatepicker').datepick({onSelect: showDate});
                    });

            function showDate(date) {
                  alert('The date chosen is ' + date);
                        }
          </script>

                    <!--  ALIEN CONTENT ENDS HERE  -->

</head>


<body>

<script>
       <?php
        if ($fgmembersite->SafeDisplay('wing')=='') $relwing='%';
        else $relwing=$fgmembersite->SafeDisplay('wing');

        if ($fgmembersite->SafeDisplay('branch')=='') $relbranch='%';
        else $relbranch=$fgmembersite->SafeDisplay('branch');


        ?>
document.getElementById("hea2").innerHTML=' Employees due for retirement ';
makelistt('%','01','cadre',<?php  echo  "'".$fgmembersite->SafeDisplay('cadre')."'";?>);
makelistt(<?php  echo  "'".$relwing."'";?>,'03','branch',<?php  echo  "'".$fgmembersite->SafeDisplay('branch')."'";?>);
makelistt(<?php  echo  "'".$relbranch."'";?>,'17','section',<?php  echo  "'".$fgmembersite->SafeDisplay('section')."'";?>);
</script>

<a href="index.php" >back to main page</a>
    <fieldset>

    <legend>Select an Office</legend>
    <form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Office:<select id="wing" name="wing"  onchange="makelistt(this.value,'03','branch')"          
           >  
          <option value='%'  <?php echo getsel('%');?> >select all</option>
        <option value='W01' <?php echo getsel('W01');?>  >GSSA</option>
        <option value='W11' <?php echo getsel('W11');?>  >ERSA</option>
        <option value='W21' <?php echo getsel('W21');?>  >PD Central</option>
        </select>
  Designation:<select id="cadre" name="cadre"   
              >   
              <option value='%' >select all</option>
                </select>
  Functional Wing:<select id="branch" name="branch"   onchange="makelistt(this.value,'17','section')"
                  >   
              <option value='%' >select all</option>
                </select>

  Section:<select id="section" name="section"   
              >   
              <option value='%' >select all</option>
                </select>
  <br><br>
  <?php
  $d21=$fgmembersite->SafeDisplay('sdate');
  $d22=$fgmembersite->SafeDisplay('edate');
  if ($fgmembersite->SafeDisplay('sdate')=='') $d21=date("d/m/Y");
  if ($fgmembersite->SafeDisplay('edate')=='') $d22='31/12/'.date("Y");

  ?>
  start date:<input type='text' name='sdate' id='sdate' placeholder="DD/MM/YY" value=<?php echo "'".$d21."'";?>  > <br>
  end date  :<input type='text' name='edate'  id='edate' placeholder="DD/MM/YY" value=<?php echo "'".$d22."'";?> >
  <input type="submit" name="list" id="subut" > 
    </form>
    </fieldset>

<form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="stab">
<tr> 
    <th><button type="button" onclick="rearrange('ps_nm')">Name</button></th> 
    <th><button type="button" onclick="rearrange('ps_cdr_id')">Designation</button></th> 
    <th><button type="button" onclick="rearrange('ps_wing')">Office</button></th> 
    <th><button type="button" onclick="rearrange('ps_brnch_id')">Functional Wing</button></th>
    <th><button type="button" onclick="rearrange('ps_sctn_id')">Section</button></th>
    <th><button type="button" onclick="rearrange('ps_dt_of_brth')">Retirement date</button></th>
        
 </tr>

<?php
   
       if (isset($_REQUEST["ord"]))
          {
          
          $wing=$_SESSION['mfwing'];
          $cadre=$_SESSION['mfcadre']; 
          $branch=$_SESSION['mfbranch'];
          $section=$_SESSION['mfsection'];
          $sdate=$_SESSION['mfsdate'];
          $edate=$_SESSION['mfedate'];
          //echo $wing;
          }  
       else if (isset($_POST["wing"]))
          {
          $sdate='to_date(\''.$_POST["sdate"].'\',\'DD/MM/YY\')';
          $edate='to_date(\''.$_POST["edate"].'\',\'DD/MM/YY\')';
          $wing=isset($_POST["wing"])?$_POST["wing"]:'%';
          $cadre=isset($_POST["cadre"])?$_POST["cadre"]:'%';
          $branch=$_POST["branch"];
          $section=isset($_POST["section"])?$_POST["section"]:'%';
          $_SESSION['mfwing']=$wing;
          $_SESSION['mfcadre']=$cadre;
          $_SESSION['mfbranch']=$branch;
          $_SESSION['mfsection']=$section;
          $_SESSION['mfsdate']=$sdate;
          $_SESSION['mfedate']=$edate;
          
          }
      
       else
          {
           $wing='%';
           $cadre='%';
           $branch='%';
           $section='%';
           $sysd=date("d/m/Y");
           $sdate='to_date(\''.date("d/m/Y").'\',\'DD/MM/YY\')';
           $edate='to_date(\''.'01/12/2018'.'\',\'DD/MM/YY\')';

           $_SESSION['mfwing']=$wing;
           $_SESSION['mfcadre']=$cadre; 
           $_SESSION['mfbranch']=$branch;
           $_SESSION['mfsection']=$section;
           $_SESSION['mfsdate']=$sdate;
           $_SESSION['mfedate']=$edate;
           
          }
          
$query="select ps_idn idd,
               ps_nm namee,
               cdr.dmn_dscrptn cadre,
               ps_floor levell,
               sec.dmn_dscrptn sectionn,
               wng.dmn_dscrptn wingg,
               brn.dmn_dscrptn branch,
               last_day(add_months(ps_dt_of_brth,720)) retdate 
        from 
               prsnl_infrmtn_systm a,
               estt_dmn_mstr sec,
               estt_dmn_mstr wng,
               estt_dmn_mstr cdr,
               estt_dmn_mstr brn
        where  ps_sctn_id=sec.dmn_id(+) and ps_wing=wng.dmn_id(+)  and cdr.dmn_id(+)=ps_cdr_id  and brn.dmn_id(+)=ps_brnch_id
          and  last_day(add_months(ps_dt_of_brth,720))>sysdate and ps_dt_of_brth is not null
          and last_day(add_months(ps_dt_of_brth,720)) between $sdate and $edate
          and ps_flg='W' 
          and ps_cdr_id like '$cadre'
          and ps_wing like '$wing' 
          and ps_sctn_id like '$section' 
          and ps_brnch_id like '$branch' 
          and nvl(ps_room_no,'0') like '%' 
            ";

$ord=" order by ps_dt_of_brth";
$ordparam='ps_dt_of_brth';
if(isset($_REQUEST["ord"])) $ordparam=$_REQUEST["ord"];
//$ordar=array('p1'=>'c1','p2'=>'c2','p3'=>'c3','cd'=>'cd','p4'=>'c4','p5'=>'c5');
//$ordparam=$ordar[$ordparam];

    if (!isset($_SESSION['toggle'])) $_SESSION['toggle']='';
    if ($_SESSION['toggle']!='desc') $_SESSION['toggle']='desc';
    else $_SESSION['toggle']='';
if (!($ordparam=='ps_dt_of_brth')) $ordparam="nvl(".$ordparam.",'0')";
$ord=" order by $ordparam ".$_SESSION['toggle'];
$query.=$ord;


 
 
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 while( $row=oci_fetch_array($statemen))
 	{
 $cadre1    =$row["CADRE"];
 $name1     =$row["NAMEE"];
 $section1  =$row["SECTIONN"]; 
 $wing1    =$row["WINGG"];
 $branch1   =$row["BRANCH"];
 $retdate1  =$row["RETDATE"];
 
 //echo 'the session variable is now:'.$_SESSION['toggle'];
 echo "<tr>
       <td>$name1</td> 
       <td>$cadre1</td> 
       <td>$wing1</td>
       <td>$branch1</td> 
       <td>$section1</td>
       <td>$retdate1</td> 
       </tr>";
	}


?>
</table>

</form>



<?php
preg_match("/[0-9]+\/[0-9]+\/[0-9]+/",$sdate,$matches1);
preg_match("/[0-9]+\/[0-9]+\/[0-9]+/",$edate,$matches2);



?>


<script>

//all fillval scripts removed

</script>

</body>