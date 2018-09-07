<!DOCTYPE html>
<html>
    <head>
<script>
    function chan(str,val)
  {
   // document.getElementById(str).value=val;
    //console.log(document.getElementById(str).innerHTML);
    var svar=document.getElementById(str).innerHTML;
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
</script>
        <title>Pick a Date</title>
        
   <!--     <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css'/>  -->
        
   <!--      <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>   -->
	</head>
	<body>
		<div id="header">
			<h2><br/>Select a Destination</h2>
		</div>
        <div class="left">
            <p>Departing: <input type="text" id="departing"></p>
        </div>
        <div class="right">
            <p>Returning: <input type="text" id="returning"></p>
        </div><br/>
        <div id="main">
        	<p>Destination: <select id="dropdown">
				<option value="newyork">New York</option>
				<option value="london">London</option>
				<option value="beijing">Beijing</option>
				<option value="moscow">Moscow</option>
			</select></p>
			<button>Submit</button>
        </div>
        <?php
        $name = "jam34/34/34fgg";
if (!preg_match("/[0-9]+\/[0-9]+\/[0-9]+/",$name,$matches)) {
  $nameErr = "Only letters and white space allowed"; 
                                                   }
echo $matches[0];
?>

<pre>
input:<input type='text' id='sam'>
output:<select id="wing" name="wing"       
           >  
            <option value='none'>-----</option>
          <option value='red'>rage</option>
        <option value='green'>peace</option>
        
        </select>
<button type="button" onclick="chan('wing','red')">click</button>

<script>
<?php
$wing='green';   
?>
    chan('wing',  <?php  echo "'".$wing."'";?>  );
</script>
</pre>

<a href="retirement.php"><img src='images\logout.jpg' alt='logout' style="width:111px;height:48px;"></a>
	</body>
</html>