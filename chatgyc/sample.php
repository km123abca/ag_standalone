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

        function checkima()
            {
                var elem=document.querySelector('#in').value;
                if (elem.match(/.jpg/g)=='.jpg')
                    alert('That was an image');
                else
                    alert('That was not an image');

            }

       function replaze(ztring,char2replace,replacewid)
       		{
       		var out_ztring=ztring;
       		var ind=ztring.indexOf(char2replace);
       		var loopcontroller=1;
       		while (ind!=-1)
       			{
       		out_ztring=out_ztring.replace(char2replace,replacewid);
       		ind=out_ztring.indexOf(char2replace);

       		loopcontroller+=1;
       		if (loopcontroller>100) break;
       			}
       			
       		return out_ztring;

       		}

       function repl()
       	{
       var ins=document.querySelector('#ta').value;
       var sm_link="<img src='uploads/smileym.jpg' height='18' width='20' alt='fatal error'>";
	   var sm_link2="<img src='uploads/smileysad.jpg' height='18' width='20' alt='fatal error'>";
       var sm_link3="<img src='uploads/txhumbsupxx.jpg' height='18' width='20' alt='fatal error'>";
       //var ou=document.querySelector('ta2').value;
       ou=replaze(ins,'thumbsup',sm_link2);
       document.querySelector('#ta2').value=ou;
       //document.querySelector('#ta2').value=ins.indexOf('h');
       //alert(ins.indexOf('h'));
       	}

    
</script>
</head>


<body>


<input id='in' name='in' type='text' size=100>
<button type='button' id='bu' onclick='matcher()'>click</button>
<button type='button' id='ext' onclick='ext2()'>check for link</button>
<button type='button' id='imslot' onclick='checkima()'>check if image</button>
<br>
<textarea id='ta' rows=10 cols=40></textarea>
<br>
<button type='button' id='buz' onclick="procw()">filter</button>
<button type='button' id='buz2' onclick="repl()">replace wo with this </button>
<br>
<textarea id='ta2' rows=10 cols=40></textarea>

<b5></b5>

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