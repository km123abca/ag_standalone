<?php
// Connection 

	require_once("./include/membersite_config.php");

	if(!$fgmembersite->CheckLogin())
		{
    $fgmembersite->RedirectToURL("login.php");
    exit;
		}
    //$query="select ps_nm,ps_idn from prsnl_infrmtn_systm where ps_nm like 'K%' and ps_flg='W'";
		$query="select cd,dmn_dscrptn cadre,nvl(c1,0) General,nvl(c2,0) SC,nvl(c3,0)  ST,
               nvl(c4,0) OBC,nvl(c5,0)  total  
            from
            (select distinct ps_cdr_id cd from prsnl_infrmtn_systm 
             where   ps_cdr_id like 'DC05'
            ) aa,

            (select ps_cdr_id cd1,count(ps_cdr_id) c1 from prsnl_infrmtn_systm where 
                    nvl(sr_sc_st_n,'GL')='GL' and ps_flg='W' and ps_wing like 'SS'
                    group by ps_cdr_id)a,

			      (select ps_cdr_id cd2,count(ps_cdr_id) c2 
					          from prsnl_infrmtn_systm where 
 					          sr_sc_st_n='SC' and ps_flg='W' and ps_wing like 'SS'
					          group by ps_cdr_id) b,
            (select ps_cdr_id cd3,count(ps_cdr_id) c3 
                    from prsnl_infrmtn_systm where 
                    sr_sc_st_n='ST' and ps_flg='W' and ps_wing like 'SS'
                    group by ps_cdr_id) c,
            (select ps_cdr_id cd4,count(ps_cdr_id) c4 
                    from prsnl_infrmtn_systm where 
                    sr_sc_st_n='OBC' and ps_flg='W' and ps_wing like 'SS'
                    group by ps_cdr_id) d,
			      (select ps_cdr_id cd5,count(ps_cdr_id) c5 
					          from prsnl_infrmtn_systm where 
 					          ps_flg='W' and ps_wing like 'SS'
					          group by ps_cdr_id) e,
      			estt_dmn_mstr 
		    where dmn_id(+)=cd and
              cd=cd1(+) and 
              cd=cd2(+) and 
              cd=cd3(+) and
              cd=cd4(+) and 
              cd=cd5(+)";

    if (isset($_REQUEST["modq"]))
    	{
    	$str=$_REQUEST["modq"];
    	$str = preg_replace('/\^/', ' ', $str);
  		$str = preg_replace('/__/', '+', $str);
  		$str = preg_replace('/nmn/', '\'', $str);
  		$query=$str;
    	}
    if (isset($_REQUEST["q"]))	
    	{
    	$query=$_REQUEST["q"];
		$query=str_replace('^',' ',$query);
		$query=str_replace(',,','+',$query);
		}
	//echo $query;
	$conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
 	$statemen=oci_parse($conn,$query);
 	
	$filename = "Webinfopen4.xls"; // File Name
	// Download file
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	// Write data to file
	
	oci_execute($statemen);
	$firstrow=True;
			//echo '<table>';
			while ($row = oci_fetch_array($statemen))
				{   $rowsel=0;
					if ($firstrow)
					{
					//echo '<tr>';
					foreach($row as $key=>$val)
						{
					$rowsel+=1;
					if (($rowsel%2)==0)									
                    echo $key."\t";
                    	}				
					echo "\r\n";
				    }  
				    $firstrow=False;
				    $rowsel=0;
				    //echo '<tr>';
					foreach($row as $key=>$val)	
						{	
					$rowsel+=1;		
					if (($rowsel%2)==0)						
                    echo $val."\t";
                    	}				
					echo "\r\n";	
					
				}
			//echo '</table>';
			
?>