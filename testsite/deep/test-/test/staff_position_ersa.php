<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
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
    th {
    background-color: #4CAF50;
    color: white;

}

button
 {
  background-color: yellow;
  color:green;
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
        
    xmlhttp.open("GET", "staff_pos_helper.php?q=" + str+"&r=W11", true);
    //console.log(str);
        xmlhttp.send();
      }
  }
  </script>
</head>


<body>

<script>
document.getElementById("h1").innerHTML=' Staff Position as on '+Date();
</script>

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
$query="select cd,dmn_dscrptn cadre,c1 tvm,c2 tcr,c3 ekm,c4 ktm,c5 kde,c6 total 
            from
            (select distinct ps_cdr_id cd from prsnl_infrmtn_systm ) aa,

            (select ps_cdr_id cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where 
                    ps_room_no='TVM' and ps_wing='W11' AND   ps_flg='W'
                    group by ps_cdr_id)a,

			(select ps_cdr_id cd2,count(ps_cdr_id) c2 
					from prsnl_infrmtn_systm where 
 					ps_room_no='TCR' and ps_wing='W11' AND   ps_flg='W'
					group by ps_cdr_id) b,

			(select ps_cdr_id cd3,count(ps_cdr_id) c3 
					from prsnl_infrmtn_systm where 
 					ps_room_no='EKM' and ps_wing='W11' AND   ps_flg='W'
					group by ps_cdr_id) c, 

			(select ps_cdr_id cd4,count(ps_cdr_id)  c4
					from prsnl_infrmtn_systm where 
 					ps_room_no='KTM' and ps_wing='W11' AND   ps_flg='W'
					group by ps_cdr_id) d,
			(select ps_cdr_id cd5,count(ps_cdr_id) c5 
					from prsnl_infrmtn_systm where 
 					ps_room_no='KDE' and ps_wing='W11' AND   ps_flg='W'
					group by ps_cdr_id) e,

			(select ps_cdr_id cd6,count(ps_cdr_id) c6 
					from prsnl_infrmtn_systm where 
 					ps_wing='W11' AND   ps_flg='W'
					group by ps_cdr_id) f,

			estt_dmn_mstr 

		where dmn_id(+)=cd and
              cd=cd1(+) and 
              cd=cd2(+) and 
              cd=cd3(+) and 
              cd=cd4(+) and
			  cd=cd5(+) and
			  cd=cd6(+)
        order by cd";


 $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
 $statemen=oci_parse($conn,$query);
 oci_execute($statemen);
 while( $row=oci_fetch_array($statemen))
 	{
 $cadre=$row["CADRE"];
 $tvmcount=$row["TVM"];
 $tcrcount=$row["TCR"];
 $ekmcount=$row["EKM"];
 $ktycount=$row["KTM"];
 $kdecount=$row["KDE"];
 $sum=$row["TOTAL"];
 //echo 'the session variable is now:'.$_SESSION['toggle'];
 echo "<tr> 
       <td>$cadre</td> 
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


</body>