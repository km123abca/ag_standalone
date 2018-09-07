<html>

<head>
<title>DIC ChatBox Beta 1</title>
<script>
lastReceived=0;

function decidecomm(res)
   {
   	
   	if(res.match(/same_user/g)=='same_user')
   		alert('dont click on your own name');
   	else
   		inf1.innerHTML+='now only '+res+' can view your messages<br>';
   }

function usersel(recr)
  {
  	
  	var sendr=signInName.innerHTML;
  	var data='sender='+sendr+'&'+'receiver='+recr;

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

// Update messages view
function showMessages(res)
	{
	serverRes.innerHTML="";
	msgTmArr=res.split("<SRVTM>");
	lastReceived=msgTmArr[1];
	messages=document.createElement("span");
	messages.innerHTML=msgTmArr[0];
	chatBox.appendChild(messages);
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

function sendMessage()
	{
	data="message="+messageForm.message.value+"&user="+signInForm.userName.value;
	//console.log(data);
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
		hideShow("show");
		messageForm.message.focus();
		updateInterval=setInterval("updateInfo()",3000);
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
			}
		if(hs=="show")
			{
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
</script>

<style>
				#signInForm, #messageForm {
				margin:0px;
				margin-bottom:1px;
											}
#userName {
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

</style>
</head>

<body onbeforeunload="signInForm.signInButt.name='signOut';signInOut()" onload="hideShow('hide')">


<h1></DIC> Chat Box</h1>
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
</body>
</html>
