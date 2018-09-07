<html>

<head>
<title>Chat with Colleagues</title>
<script>
lastReceived=0;

function decidecomm(res)
   {
   	
   	if(res.match(/same_user/g)=='same_user')
   		alert('dont click on your own name');
   	else
   		{
   			if (res=='cleared')
   				inf1.innerHTML='now, everyone can view your messages<br>';
   			else
   			inf1.innerHTML='now only '+res+' can view your messages<br>';

   	    }
   }

function usersel(recr)
  {
  	receiver=recr.innerHTML;
  	//recr.style.backgroundColor='green';
  	var sendr=signInName.innerHTML;
  	var data='sender='+sendr+'&'+'receiver='+receiver;

  	Ajax_Send("GET","decidecomm.php",data,decidecomm);

  }


  function unhook()
  {
  	
  	var sendr=signInName.innerHTML;
  	var data='cs='+sendr;
  	Ajax_Send("GET","decidecomm.php",data,decidecomm);

  }

// Sign out response
function checkSignOut(res)
	{
	if(res=="usernotfound")
		{
		serverRes.innerHTML="Sign out error";
		res="signout";
		}
	if(res.match(/signout/g)=="signout")
		{
		hideShow("hide");
		signInForm.userName.focus();
		clearInterval(updateInterval);
		serverRes.innerHTML="Sign out";
		return false;
		}
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
     		if (midstr.match(/.JPG/g)=='.JPG')
     			{
     			var imtag="<img src='"+midstr+"' alt='no preview' height='100' width='150'>";
     			midstr_mod="<br><a href='"+midstr+"' target=blank>"+imtag+"</a>";

     			}
     		else
     		midstr_mod="<a href='"+midstr+"' target=blank>attachment</a>";
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

// Update messages view
function showMessages(res)
	{
	serverRes.innerHTML="";
	msgTmArr=res.split("<SRVTM>");
	lastReceived=msgTmArr[1];
	messages=document.createElement("span");
	msg2pr=msgTmArr[0];
	msg2pr=shapelinks(msg2pr);
	msg2pr=smiley_filter(msg2pr);
	//alert(msgarr);
	messages.innerHTML=msg2pr;
	chatBox.appendChild(messages);
	if (msg2pr!='')
	chatBox.scrollTop=chatBox.scrollHeight;
	}


// update online users
function showUsers(res)
	{
	usersOnLine.innerHTML=res;
	}


// Update info
function updateInfo()
	{
	var sendr=signInName.innerHTML;
	serverRes.innerHTML="Updating";
	Ajax_Send("GET","users.php","",showUsers);
	Ajax_Send("GET","receive.php","lastreceived="+lastReceived+"&sendr="+sendr,showMessages);
	}

// Sent Ok
function sentOk(res)
	{
		//console.log(res);
	if(res.match(/sentok/g)=="sentok")
		{
		messageForm.message.value="";
		messageForm.message.focus();
		serverRes.innerHTML="Sent";
		}
	else{
		serverRes.innerHTML="Not sent";
		}
	}

function updateuploadinfo()
	{

document.querySelector('uploadinffo').innerHTML='';		
	}



function smiley_filter(msg2)
	{   var msg3=msg2;
		var sm_link="<img src='uploads/smileym.jpg' height='18' width='20' alt='fatal error'>";
		var sm_link2="<img src='uploads/smileysad.jpg' height='18' width='20' alt='fatal error'>";
		var sm_link3="<img src='uploads/txhumbsupxx.jpg' height='18' width='20' alt='fatal error'>";
		var sm_link4="<img src='uploads/mock.jpg' height='18' width='20' alt='fatal error'>";
		var sm_link5="<img src='uploads/angry.jpg' height='18' width='20' alt='fatal error'>";
		
		msg3=replaze(msg3,':-)',sm_link);
		msg3=replaze(msg3,':-(',sm_link2);
		msg3=replaze(msg3,'thumbsup',sm_link3);
		msg3=replaze(msg3,':-0',sm_link4);
		msg3=replaze(msg3,':-^',sm_link5);
		return msg3;

	}

function sendMessage()
	{
	var linkdat=document.getElementById('atac').innerHTML;
	//var message_typed=messageForm.message.value;
	//message_typed=smiley_filter(message_typed);
	data="message="+messageForm.message.value+"&user="+signInForm.userName.value+"&linkdat="+linkdat;
	//console.log(data);
	if (linkdat!='none') document.getElementById('atac').innerHTML='none'; 
	updateuploadinfo();
	serverRes.innerHTML="Sending";
	Ajax_Send("GET","send.php",data,sentOk);
	}

// Sign in response
function checkSignIn(res)
	{
		//res=res.match(/signin/g);
		//console.log(res);
	if(res.match(/userexist/g)=="userexist")
		{
		alert("The user name you typed is already exist\nPlease try another one");
		return false;
		}
	if(res.match(/signin/g)=="signin")
		{
		document.getElementById('us_nm').value=signInForm.userName.value;
		hideShow("show");
		messageForm.message.focus();
		updateInterval=setInterval("updateInfo()",1000);
		serverRes.innerHTML="Sign in";
		}
	}


// Sign in and Out
function signInOut()
	{
// Validation
	if (signInForm.userName.value=="" || signInForm.userName.value.indexOf(" ")>-1)
		{
		alert("Not valid user name\nPlease make sure your user name didn't contains a space\nOr it's not empty.");
		signInForm.userName.focus();
		return false;
		}
// Sign in
	if (signInForm.signInButt.name=="signIn")
		{
		data="user=" + signInForm.userName.value +"&oper=signin";
		Ajax_Send("GET","users.php",data,checkSignIn);
		return false;
		}

// Sign out
		if (signInForm.signInButt.name=="signOut")
			{
			data="user=" + signInForm.userName.value +"&oper=signout";
			Ajax_Send("GET","users.php",data,checkSignOut);
			return false;
			}
	}



function hideShow(hs)
		{
		if(hs=="hide")
			{
			signInForm.signInButt.value="Sign in";
			signInForm.signInButt.name="signIn";
			messageForm.style.display="none";
			signInForm.userName.style.display="block";
			signInName.innerHTML="";
			uploadformz.style.display='none';
			}
		if(hs=="show")
			{
			uploadformz.style.display='block';
			signInForm.signInButt.value="Sign out";
			signInForm.signInButt.name="signOut";
			messageForm.style.display="block";
			signInForm.userName.style.display="none";
			signInName.innerHTML=signInForm.userName.value ;
			}
		}


function Ajax_Send(GP,URL,PARAMETERS,RESPONSEFUNCTION)
	{ 
		
		var xmlhttp;
		try {
			 xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
		catch(e)
		      {
               try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
               catch(e){
                        try{xmlhttp=new XMLHttpRequest();}
                        catch(e){
								alert("Your Browser Does Not Support AJAX");
								}
						}
			   }

		err="";
        if (GP==undefined) err="GP ";
        if (URL==undefined) err +="URL ";
        if (PARAMETERS==undefined) err+="PARAMETERS";
        if (err!="") 
        	{alert("Missing Identifier(s)\n\n"+err);
             return false;
            }

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
						PARAMETERS=encodeURI(PARAMETERS);
						xmlhttp.open("POST",URL,true);
						xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.setRequestHeader("Content-length",PARAMETERS.length);
						xmlhttp.setRequestHeader("Connection", "close");
						xmlhttp.send(PARAMETERS);
						}
	}


																		function fillsmile(emo)
																		{
																	    var locstr;
																		if (emo=='smile') locstr=' :-)';
																		else if (emo=='sad') locstr=' :-(';
																		else if (emo=='tup') locstr=' thumbsup';
																		else if (emo=='moc') locstr=' :-0';
																		else if (emo=='ang') locstr=' :-^';

																		if(signInForm.signInButt.name=='signOut')
																			messageForm.message.value+=locstr;

																		}
</script>

<style>
				#signInForm, #messageForm 
							{
							margin:0px;
							margin-bottom:1px;
											
							}
				#userName 	{
							width: 150px;
							height: 22px;
							border: 1px teal solid;
							float:left;
							}
				#signInButt {
							width: 60px;
							height: 22px;
							}	
				#signInName{
							font-family:Tahoma;
							font-size:12px;
							color:orange;
							}
				#chatBox {
							font-family:tahoma;
							font-size:12px;
							color:black;
							border: 1px teal solid;
							height: 225px;
							width: 400px;
							overflow: scroll;
							float:left;

						}
#usersOnLine{
	font-family:tahoma;
	font-size:14;
	color:orange;
	border:1px teal solid;
	width:150px;
	height:225px;
	overflow:scroll;
	margin-left:1px;
}
#message {
	width: 350px;
	height: 22px;
	border: 1px teal solid;
	float:left;
	margin-top:1px;
}
#send {
	width: 50px;
	height: 22px;
	float:left;
	margin:1px;
}
#serverRes{
	width:150px;
	height:22px;
	border: 1px teal solid;
	float:left;
	margin:1px;
}
.botbu
	{
	cursor: pointer;
	}
.usersel
		{
			cursor: pointer;
    		width: 100%;
		}

</style>
</head>
<?php 
function getlink()
	{
		$lin='#';
		if (isset($_REQUEST['linn'])) 
		$lin=$_REQUEST['linn'];
		if ($lin=='#')
		$linna="<a href='$lin' target='blank'>attachment</a>";
		else
		$linna="<a href='$lin' target='blank'>No attachment</a>";
		return $linna;
	}

function getlinkraw()
	{
		$lin='#';
		if (isset($_REQUEST['linn'])) 
		$lin=$_REQUEST['linn'];
		return $lin;
	}

function getuser()
		{
$cuser='User name';
if (isset($_REQUEST['us_nm'])) $cuser=$_REQUEST['us_nm'];
return $cuser;
		}

function livve()
		{
$cuser=False;
if (isset($_REQUEST['us_nm'])) $cuser=True;
return $cuser;
		}



?>

<body   <?php
		 //if (!(isset($_FILES["fileToUpload"])))
		echo "onbeforeunload=\"signInForm.signInButt.name='signOut';signInOut()\" ";
	    //if (!(isset($_REQUEST["linn"])))
		echo "onload=\"hideShow('hide')\"";
		?>
>


<h1 style='width:100%;text-align: center;'> Chat Box</h1>
<infuser id='inf1'></infuser>
<form id="signInForm" onsubmit="signInOut();return false">
	<input id="userName" type="text">
	<input id="signInButt" name="signIn" type="submit" value="Sign in">
	<span id="signInName">User name</span>
</form>



<div id="chatBox"></div>

<div id="usersOnLine"></div>

<form id="messageForm" onsubmit="sendMessage();return false">
	<input id="message" type="text">
	<input id="send" type="submit" value="Send">
<div id="serverRes"></div>
</form>


<script>
						<?php
						if (livve())
									{
						echo "signInForm.signInButt.name='signIn';";
						echo "signInForm.userName.value='".getuser()."';";
						echo "signInOut();";
						//echo "messageForm.message.value='".getlink()."';";
									}
						?>

</script>


<br><br>
<form action="fileupload.php" method="post" enctype="multipart/form-data" id='uploadformz'>
<input type="file" name="fileToUpload" id="fileToUpload" class='labtdx' >
<input type="submit" value="Upload" name="submit" class='labtdx'>
<input type='text' style='display: none;' id='us_nm' name='us_nm'>

</form>
<br>
<button type='button' class='botbu labtdx' onclick="unhook()">Make my messages visible to all</button>
<br>
<uploadinffo style="font-weight: bold;color:#0000FF;font-size: 20px;font-style: italic;"></uploadinffo>
<?php 
	//echo getlink();
?>
<atac id='atac' name='atac' style="display:none;">
	<?php 
	if (livve())
	echo getlinkraw();
    else 
    echo 'none';
    ?>
</atac>
<script>
            var atacstat=document.querySelector('atac').innerHTML;
           
			if(atacstat.match(/none/g)!='none')
				document.querySelector('uploadinffo').innerHTML='YOU HAVE SELECTED A FILE TO BE UPLOADED.ONCE YOU PRESS ENTER THE ATTACHMENT WILL BE SENT ALONG WITH YOUR MESSAGE';
			//alert(document.querySelector('atac').innerHTML);
</script>

<br>
<a href="javascript:fillsmile('smile')"><img src='uploads/smileym.jpg' height='18' width='20' alt='fatal error'></a>
<a href="javascript:fillsmile('sad')"><img src='uploads/smileysad.jpg' height='18' width='20' alt='fatal error'></a>
<a href="javascript:fillsmile('tup')"><img src='uploads/txhumbsupxx.jpg' height='18' width='20' alt='fatal error'></a>
<a href="javascript:fillsmile('moc')"><img src='uploads/mock.jpg' height='18' width='20' alt='fatal error'></a>
<a href="javascript:fillsmile('ang')"><img src='uploads/angry.jpg' height='18' width='20' alt='fatal error'></a>

</body>
</html>
