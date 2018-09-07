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
      if (isset($_POST["wng"]))
         {
          $disp=($str==($_POST["wng"]))?'selected':'';
         }
      return $disp;
      }
?>
<head>

<h1 id="h1">   </h1>

<style>
            table, th, td 
	           {
              border: 1px solid black;
              text-align: left;
              border-collapse: collapse;
             }
              tr:hover {background-color: #f5f5f5;}
              tr:nth-child(even) {background-color: #f2f2f2;}
              th 
              {
              background-color: #4CAF50;
              color: white;
              }
              button
              {
              background-color: yellow;
              color:green;
              font-weight: bold;
               }
               .lg
               {
                width:50%;
                margin-left: 27%;
               }
               b1
               {
                color:red;
               }
               .purple
                {
                background-color: #f0f8ff;
                }
                .bl
                {
                  font-weight: bold;
                }
 </style>
<script >
 function rearrange(str)
  {  
    //document.getElementById("wing").value=document.getElementById("wing1").value;
    //console.log('Entered the function with '+str);
    if (str.length!=0)
      {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
        {
    if (this.readyState == 4 && this.status == 200)
          {    //console.log('The resposeText received is this '+this.responseText);

        var headerString="<tr><th><button type=\"button\" onclick=\"rearrange('dmn_dscrptn')\">Designation</button></th>"+ 
                              "<th><button type=\"button\" onclick=\"rearrange('c1')\">TVM</button></th>"+ 
                              "<th><button type=\"button\" onclick=\"rearrange('c2')\">TCR</button></th>"+ 
                              "<th><button type=\"button\" onclick=\"rearrange('c3')\">EKM</button></th>"+ 
                              "<th><button type=\"button\" onclick=\"rearrange('c4')\">KTM</button></th>"+ 
                              "<th><button type=\"button\" onclick=\"rearrange('c5')\">KDE</button></th>"+ 
                              "<th><button type=\"button\" onclick=\"rearrange('c6')\">Sum</button></th>"+    
                          "</tr>";
    document.getElementById("stab").innerHTML=headerString+  this.responseText;
    //console.log('Request sent and received with '+str);
          }
        };
       <?php if (!(isset($wingg))) $wingg='W01';   ?>
    xmlhttp.open("GET", "combinedcadreshelper.php?q=" + str+"&r=<?php echo $wingg;?>", true);
    //console.log(str);
        xmlhttp.send();
      }
  }
  </script>
</head>


<body class='purple'>

<script>
document.getElementById("h1").innerHTML=' Staff Position as on '+Date();
</script>
<fieldset class="lg">
<table id="stab">
<tr> 
    <th><button type="button" onclick="rearrange('dmn_dscrptn')">Designation</button></th> 
    <th><button type="button" onclick="rearrange('c1')">         TVM        </button></th> 
    <th><button type="button" onclick="rearrange('c2')">         TCR        </button></th> 
    <th><button type="button" onclick="rearrange('c3')">         EKM        </button></th> 
    <th><button type="button" onclick="rearrange('c4')">         KTM        </button></th> 
    <th><button type="button" onclick="rearrange('c5')">         KDE        </button></th> 
    <th><button type="button" onclick="rearrange('c6')">         Sum        </button></th>    
 </tr>
<?php
//session_start();
//$_SESSION["toggle"]='desc';

$wingg='W01';
if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('wng',$_POST))) 
  {
    if (isset($_POST["wng"]))
    $wingg=$_POST["wng"];
  }
  //echo $wingg;
if ($wingg=='W01')
  echo "<b1>Staff Strength of GSSA</b1>";
elseif($wingg=='W11')
  echo "<b1>Staff Strength of ERSA</b1>";
elseif($wingg=='W21')
  echo "<b1>Staff Strength of PDC</b1>";
$query="select cd,dmn_dscrptn cadre,c1 tvm,c2 tcr,c3 ekm,c4 ktm,c5 kde,c6 total 
            from
            (select distinct 
            decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )
            cd from prsnl_infrmtn_systm 
            union select 'sum' cd from dual
            ) aa,

            (select 
            decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )
 
            cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where 
                    ps_room_no='TVM' and ps_wing='$wingg' AND   ps_flg='W'
                    group by 
                    decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

                   union select 'sum' cd1,count(ps_idn) c1 from prsnl_infrmtn_systm 
                   where ps_room_no='TVM' and ps_wing='$wingg' AND   ps_flg='W'  
                                    
                    )a,

			(select 
      decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

       cd2,count(ps_cdr_id) c2 
					from prsnl_infrmtn_systm where 
 					ps_room_no='TCR' and ps_wing='$wingg' AND   ps_flg='W'
					group by 
          decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

                   union select 'sum' cd2,count(ps_idn) c2 from prsnl_infrmtn_systm 
                   where ps_room_no='TCR' and ps_wing='$wingg' AND   ps_flg='W'
                   
          ) b,

			(select 
      decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )
       cd3,count(ps_cdr_id) c3 
					from prsnl_infrmtn_systm where 
 					ps_room_no='EKM' and ps_wing='$wingg' AND   ps_flg='W'
					group by 
          decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

                   union select 'sum' cd3,count(ps_idn) c3 from prsnl_infrmtn_systm 
                   where ps_room_no='EKM' and ps_wing='$wingg' AND   ps_flg='W'
                   
          ) c, 

			(select 
      decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

       cd4,count(ps_cdr_id)  c4
					from prsnl_infrmtn_systm where 
 					ps_room_no='KTM' and ps_wing='$wingg' AND   ps_flg='W'
					group by 
          decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

                   union select 'sum' cd4,count(ps_idn) c4 from prsnl_infrmtn_systm 
                   where ps_room_no='KTM' and ps_wing='$wingg' AND   ps_flg='W'
                   
          ) d,
			(select 
      decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

       cd5,count(ps_cdr_id) c5 
					from prsnl_infrmtn_systm where 
 					ps_room_no='KDE' and ps_wing='$wingg' AND   ps_flg='W'
					group by 
          decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

                   union select 'sum' cd5,count(ps_idn) c5 from prsnl_infrmtn_systm 
                   where ps_room_no='KDE' and ps_wing='$wingg' AND   ps_flg='W'
                   
          ) e,

			(select 
      decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

       cd6,count(ps_cdr_id) c6 
					from prsnl_infrmtn_systm where 
 					ps_wing='$wingg' AND   ps_flg='W'
					group by 
          decode(ps_cdr_id,
                   'DA00','GR.A',
                   'DA01','GR.A',
                   'DA02','GR.A',
                   'DA03','GR.A',
                   'DA04','GR.A',
                   'DA05','GR.A',
                   'DA07','GR.A',
                   'DA08','GR.A',
                   'DA09','GR.A',
                   'DA10','GR.A',
                   'DB01','Sr AO/AO',
                   'DB02','Sr AO/AO',
                   'DB03','EDP',
                   'DB04','Sr AO/AO',
                   'DB05','Sr AO/AO',
                   'DB06','Sr AO/AO',
                   'DB07','PS/SrPS',
                   'DB08','EDP',
                   'DB09','Hindi Posts', 
                   'DB11','AAO/Supr',
                   'DB12','EDP',
                   'DB13','PS/SrPS',
                   'DB14','AAO/Supr',
                   'DB15','AAO/Supr',
                   'DB16','AAO/Supr',
                   'DB17','AAO/Supr',
                   'DB18','AAO/Supr',
                   'DB19','Adr/SrAdr',
                   'DB20','Hindi Posts',
                   'DB21','PS/SrPS',
                   'DB22','EDP',
                   'DB24','Sr AO/AO',
                   'DB25','Sr AO/AO',
                   'DB26','Sr AO/AO',
                   'DB27','Sr AO/AO',
                   'DB28','AAO/Supr',
                   'DB29','AAO/Supr',
                   'DB30','Sr AO/AO',
                   'DB31','Sr AO/AO',
                   'DB32','Sr AO/AO',
                   'DB33','Sr AO/AO',
                   'DB34','Sr AO/AO',
                   'DB35','Sr AO/AO',
                   'DB36','PS/SrPS',
                   'DB37','AAO/Supr',
                   'DC01','Adr/SrAdr',
                   'DC02','PS/SrPS',
                   'DC03','Hindi Posts',
                   'DC05','Adr/SrAdr',
                   'DC06','PS/SrPS',
                   'DC07','EDP',
                   'DC08','EDP',
                   'DC09','Adr/SrAdr',
                   'DC10','Clerk/MTS',
                   'DC11','Clerk/MTS',
                   'DC12','Clerk/MTS',
                   'DC13','PS/SrPS',
                   'DC14','EDP',
                   'DC15','Adr/SrAdr',
                   'DC16','Adr/SrAdr',
                   'DC17','EDP',
                   'DC18','Clerk/MTS',
                   'DC19','Hindi Posts',
                   'DD01','Clerk/MTS'
                   )

                   union select 'sum' cd6,count(ps_idn) c6 from prsnl_infrmtn_systm 
                   where  ps_wing='$wingg' AND   ps_flg='W'
                   
          ) f,

			estt_dmn_mstr 

		where dmn_id(+)=cd and
              cd=cd1(+) and 
              cd=cd2(+) and 
              cd=cd3(+) and 
              cd=cd4(+) and
			  cd=cd5(+) and
			  cd=cd6(+)
        order by decode(cd,'GR.A',1,'Sr AO/AO',2,'AAO/Supr',3,
                         'Adr/SrAdr',4,'Hindi Posts',5,'PS/SrPS',6,
                         'EDP',7,'Clerk/MTS',8,9) ";


 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 while( $row=oci_fetch_array($statemen))
 	{
 $cadre=$row["CD"];
 $tvmcount=$row["TVM"];
 $tcrcount=$row["TCR"];
 $ekmcount=$row["EKM"];
 $ktycount=$row["KTM"];
 $kdecount=$row["KDE"];
 $sum=$row["TOTAL"];
 //echo 'the session variable is now:'.$_SESSION['toggle'];
 echo "<tr> 
       <td class='bl'>$cadre</td> 
       <td>$tvmcount</td>
       <td>$tcrcount</td> 
       <td>$ekmcount</td>
       <td>$ktycount</td>  
       <td>$kdecount</td>
       <td>$sum</td> 
        </tr>";
	}

  
?>
</table>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset>
<legend>Choose Wing</legend>
Wing:
     <select id="wng" name="wng"  >
     <option value='W01' <?php echo getsel('W01');?> >GSSA</option>
     <option value='W11' <?php echo getsel('W11');?> >ERSA</option>
     <option value='W21' <?php echo getsel('W21');?> >PDC</option>
     </select>

<input type="submit" name="submit" id="subut" value="Enter" >
</fieldset>
</form>
</fieldset>
<a href="index.php">Back to Main Menu</a>

</body>