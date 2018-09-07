<?php
require_once("./include/membersite_config.php");


      function descr($dmnid,$conn)
        { 
        if ($dmnid=='%') return "select all";
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


    $typ='notype';
    $descreq='nodesc';
    $resptyp='select';
    $col='ps_nm';
    $tab='prsnl_infrmtn_systm';
    $default_value='none';

    if (isset($_REQUEST["defval"])) $default_value=$_REQUEST["defval"];
    if (isset($_REQUEST["resptyp"])) $resptyp=$_REQUEST["resptyp"];
    if (isset($_REQUEST["col"])) $col=$_REQUEST["col"];
    if (isset($_REQUEST["tab"])) $tab=$_REQUEST["tab"];
    if (isset($_REQUEST["typ"])) $typ=$_REQUEST["typ"];
    if (isset($_REQUEST["descreq"])) $descreq=$_REQUEST["descreq"];

    if ($typ=='notype')
      $query="select distinct $col validd,$col val from $tab";
    elseif ($descreq=='nodesc')
      $query="select distinct $col validd,$col val from $tab where dmn_typ='$typ'";
    else
      $query="select dmn_id validd,dmn_dscrptn val from estt_dmn_mstr where dmn_typ='$typ'"; 
    $query.=" order by validd";

    $conn=oci_connect($fgmembersite->orauser(),$fgmembersite->orap(),$fgmembersite->oraho());
	   if (!$conn)
			{
				echo 'Failed to connect to Oracle';
	     		die("Connection failed: " . $conn->connect_error);
			}

      $statemen=oci_parse($conn,$query);
      oci_execute($statemen);
      $respotext="";
      if ($default_value!='none') 
        {
          $defdesc=descr($default_value,$conn);
          $respotext.="<option value='$default_value'>$defdesc</option>";
        }
      while ($row=oci_fetch_array($statemen))
 	      {
 		
      $listitemid=$row["VALIDD"];
      $listitem=$row["VAL"];

      if ($resptyp=='select') 	$respotext.="<option value='$listitemid'>$listitem</option>";
      else $respotext.="<option value='$listitem'> ";
       	}



 echo $respotext;//('DC05','DC07','DC01','DB11','DB14','DC03','DC13','DC17')
?>