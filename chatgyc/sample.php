<head>


<script>
	function matcher()
		{
	var el=document.getElementById('in').value;
	window.location.href='sample.php?val='+el;
		}


    function ext()
    	{
    var el=document.getElementById('in').value;
    if(el.match(/<a href=/g)=="<a href=")
    		{
    		alert('This one conatins a link');
    		f=el.indexOf("!@#$zhinyat")+1;
    		s=el.indexOf("!@#$zhinyat",f+1)-1;

    		f2=el.indexOf("!@#$zhinyat")+1;
    		s2=el.indexOf("!@#$zhinyat",f+1)-1;

    		//alert('The first apostrophe is at '+f+' and the second at '+s);
    		alert(el.substr(f,s-f+1));
    		alert(el.substr(f2,s2-f2+1));
    		}
    	}

     function ext2()
    	{
    var el=document.getElementById('in').value;
    
    		alert('This one conatins a link');
    		f=el.indexOf("!@#$zhinyat")+11;
    		s=el.indexOf("!@#$zhinyat",f+1)-1;

    		f2=el.indexOf("!@#$zhinyat")+11;
    		s2=el.indexOf("!@#$zhinyat",f+1)-1;

    		//alert('The first apostrophe is at '+f+' and the second at '+s);
    		alert(f);
    		alert(el.substr(f2,s2-f2+1));
    		
    	}

     function fil_er()
     	{
     		var inptex=document.querySelector('#ta').value;
     		var ouptex;
     		var t1=document.querySelector('#in').value;
     		var len=t1.length;
     		var midstr='';
     		var itercntrl=1;
     		var cnrtll=0;
     		var emptyst='';
     		
     		st_in=0;
     		x=inptex.indexOf(t1,st_in);



     		while (cnrtll!=-1)
     			{
     		
     		x=inptex.indexOf(t1,st_in)+len;

     		y=inptex.indexOf(t1,x);
     		st_in=y+1;
     		midstr=inptex.substr(x,y-x);
     		midstr_mod="<a href='"+midstr+"'>attachment</a>";
     		alert(t1+midstr+t1);
     		alert(midstr_mod);
     		inptex=inptex.replace(t1+midstr+t1,midstr_mod);
     		//alert(midstr);
     		//emptyst+=midstr+' ';
     		itercntrl+=1;
     		if (itercntrl>10) break;
     		cnrtll=inptex.indexOf(t1,st_in);

     			}
     		document.querySelector('#ta2').value=inptex;
     	} 


     	function shapelinks(inptex)
     	{
     		
     		var ouptex;
     		var t1='!@#$zhinyat';
     		var len=t1.length;
     		var midstr='';
     		var itercntrl=1;
     		var cnrtll=0;
     		var emptyst='';
     		
     		st_in=0;
     		x=inptex.indexOf(t1,st_in);



     		while (cnrtll!=-1)
     			{
     		
     		x=inptex.indexOf(t1,st_in)+len;

     		y=inptex.indexOf(t1,x);
     		st_in=y+1;
     		midstr=inptex.substr(x,y-x);
     		midstr_mod="<a href='"+midstr+"'>attachment</a>";
     		//alert(t1+midstr+t1);
     		//alert(midstr_mod);
     		inptex=inptex.replace(t1+midstr+t1,midstr_mod);
     		//alert(midstr);
     		//emptyst+=midstr+' ';
     		itercntrl+=1;
     		if (itercntrl>10) break;
     		cnrtll=inptex.indexOf(t1,st_in);

     			}
     		return inptex;
     	} 

     	function procw()
     		{
     			document.querySelector('#ta').value=shapelinks(document.querySelector('#ta').value);
     		}


    
</script>
</head>


<body>


<input id='in' name='in' type='text' size=100>
<button type='button' id='bu' onclick='matcher()'>click</button>
<button type='button' id='ext' onclick='ext2()'>check for link</button>
<br>
<textarea id='ta' rows=10 cols=40></textarea>
<br>
<button type='button' id='buz' onclick="procw()">filter</button>
<br>
<textarea id='ta2' rows=10 cols=40></textarea>

<script>
<?php
$elem='none';
if (isset($_REQUEST['val']))
		{
$elem=$_REQUEST['val'];
//if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$elem))
echo "alert('$elem');";
		}

?>
</script>
</body>