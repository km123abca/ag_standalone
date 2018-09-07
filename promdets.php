<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());

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
              .hea2
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
             .colgrey
             {
              color:#545d6b;
             }
             .bl
             {
              font-weight: bold;

             }
 </style>
<script >



 function Ajax_Send(GP,URL,PARAMETERS,RESPONSEFUNCTION)
  {     
    var xmlhttp  = new XMLHttpRequest();;
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState == 4){
      if (RESPONSEFUNCTION=="") return false;
      //console.log('hello'+RESPONSEFUNCTION);
      eval(RESPONSEFUNCTION(xmlhttp.responseText))
                    }
                       }

      if (GP=="GET")
            {
            URL+="?"+PARAMETERS;
            xmlhttp.open("GET",URL,true);
            xmlhttp.send(null);
            }

      if (GP=="POST")
            {
           return false;
            }
  }
 
function vallist(col)
						{
							gp='GET';
              url='vallist.php';
              params='q='+col;
              respfn=deal;
              Ajax_Send(gp,url,params,respfn);
						}

function deal(resptext)
  {
    //console.log(resptext);
    document.getElementById('namlist').innerHTML=resptext;
  }

 vallist('ps_nm'); 
  </script>

 

</head>


<body style="background-color: #8cade2">



<a href="index.php" >back to main page</a>
    <fieldset>

    <legend class='bl'>Promotion Details</legend>
    <form method="post"  id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   <b class='bl'>Name</b>:<input type='text' name='empnm' id='empnm' list='namlist'>
   <datalist id='namlist'></datalist>

   <input type="submit" name="maindbsub" value="Get" id="maindbsub" class='maindbbutton'> 
    </form>
    </fieldset>

<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('empnm',$_POST)))
{



 $nm=$_POST['empnm'];
          
$query="select ps_idn idd,
               ps_nm namee,
               cdr.dmn_dscrptn cadre,
               ps_floor levell,
               sec.dmn_dscrptn sectionn,
               wng.dmn_dscrptn wingg,
               brn.dmn_dscrptn branch,
               pm_prmtn_cdr_id,
               pm.dmn_dscrptn promcad,
               to_char(pm_dt_of_prmtn,'DD-MON-YYYY') dp
        from 
               prsnl_infrmtn_systm a,
               estt_dmn_mstr sec,
               estt_dmn_mstr wng,
               estt_dmn_mstr cdr,
               estt_dmn_mstr brn,
               estt_dmn_mstr pm,
               estt_prmtn
        where  ps_sctn_id=sec.dmn_id(+) and ps_wing=wng.dmn_id(+)  and cdr.dmn_id(+)=ps_cdr_id  and brn.dmn_id(+)=ps_brnch_id
          and  pm.dmn_id(+)=pm_prmtn_cdr_id and pm_idn=ps_idn
          and ps_flg='W' 
          and ps_nm like '$nm' order by pm_prmtn_cdr_id
            ";


 
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 $count=0;
 while( $row=oci_fetch_array($statemen))
 	{
 		$count+=1;
 		if ($count==1)
 		{   
 			echo " <div class='hea2 colgrey'>Promotion History of </div><div class='hea2'>".$nm.", ".$row["CADRE"]."</div>";
 			
 			echo "<table id='stab'>";
			echo "<tr>"; 
			echo "<th>Posted as</th>" ;
			echo "<th>Date of Posting</th>" ;
 			echo "</tr>";
 		}
 $cadre1    =$row["PROMCAD"];
 $name1     =$row["DP"];
  

 echo "<tr>
       <td>$cadre1</td> 
       <td>$name1</td>
       </tr>";
	}

echo "</table>";



}

?>





</body>