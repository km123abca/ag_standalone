<?PHP
require_once("./include/membersite_config.php");

if($fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("index.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
       // $fgmembersite->RedirectToURL("login-home.php");
        $fgmembersite->RedirectToURL("index.php");//KM
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Login</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
      <style>
      #button {

              background-color: #4CAF50;
               color: white;
              padding: 14px 20px;
              margin: 8px 0;
              border: none;
              cursor: pointer;
              width: 100%;
              }

          #button1 {

              background-color: #4CAF50;
               color: white;
              padding: 14px 20px;
              margin: 8px 0;
              border: none;
              cursor: pointer;
              width: 100%;
              }
              .toolmas .tooltex
            {
           visibility: hidden;
           position: absolute;
           background-color: black;
             color: #fff;
             text-align: center;
             padding: 5px 0;
             border-radius: 6px;
             z-index: 1;
            }
           .toolmas:hover .tooltex
              {
                visibility:visible;
              }
           .toolmas
              {
              position: relative;
              display: inline-block;

              }

            .fllef
            {
              float:left;
            }

            #fg_membersite
            {float:left;

             }
           
              #login3
              {
                
                position: relative;
                top:-12px;
              }

              #login4
              {
                position: relative;                 
                top:-12px;
              }
              
              #jumbo1
              {
                position: relative;
                float:left;
                /* border:1px solid black;*/
                width:20%;                

              }

              #jumbo2
              {
                position: relative;
                float:left;
                /* border:1px solid black;*/
                width:20%;   


              }
              #imagecont
              {
                width:59%;
                float:left;
                padding-left: 2px;
                 /* border:1px solid black;*/
              }
              /*
              body
              {
              background-image:url('images/im1.jpg');	
              background-repeat: no-repeat;
              background-size:cover;
              }

              fieldset
              {
              	background-color: #999;
              }*/

              #hea2
              {
              text-align: center;
              float:left;
              width:100%;
              font-weight: bold;
              background-color:#eee; 
              font-size: 36px;
              }


      

      </style>

      <script>
      function vallist(col,elem,opto='no',sellist='n')
            {
              //if (sellist=='y')
                //console.log(' col:'+col+' elem:'+elem);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
            if (this.readyState == 4 && this.status == 200)
              {    //console.log('The resposeText received is this '+this.responseText);
            //if (sellist=='y')
                //console.log(' resptex:'+this.responseText);
          document.getElementById(elem).innerHTML=this.responseText;
              }
            };
          if ((opto!='desc')&&(sellist=='n'))
          xmlhttp.open("GET", "vallist.php?q=" + col, true);
            else if(sellist=='y')
            xmlhttp.open("GET", "vallist2.php?q=" + col, true); 
            else
            xmlhttp.open("GET", "vallist.php?q=" + col+"&b="+'desc', true);
            xmlhttp.send();
            }
      </script>
      <h3 id="hea2">Office of the accountant general GSSA, Thiruvananthapuram</h3>
</head>
<body>
 
<!-- Form Code Start -->
<div id='jumbo1'>
<div id='fg_membersite'>

<form id='login3' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'  >
      <fieldset>
        <legend>Master Login</legend>
        <input type='hidden' name='submitted' id='submitted' value='1'/>
        <div class='short_explanation'>* required fields</div>
        <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
        <div class='container'>
        <label for='username' >UserName*:</label><br/>
        <input type='text' name='username' id='username' 
        value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
        <span id='login_username_errorloc' class='error'></span>
        </div>
        <div class='container'>
        <label for='password' >Password*:</label><br/>
        <input type='password' name='password' id='password' maxlength="50" /><br/>
        <span id='login_password_errorloc' class='error'></span>
        </div>
        <div class='container'>
        <input type='submit' name='Submit' value='Submit' id='button' />
        </div>
        <tm class="toolmas">
        <div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>
        <tt class="tooltex"> <?php echo "hint:".$fgmembersite->gethint();?> </tt>
        </tm>
      </fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->


</div>
</div>

<div id="imagecont">
<img src='images/im1.jpg' id="ima" alt="No Photo"  style="width:100%;height: 500px;">
</div>


<div id="jumbo2">
<div id='fg_membersite' >

<form id='login4' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'  >
      <fieldset>
        <legend>Normal Login</legend>
        <input type='hidden' name='submitted' id='submitted1' value='1'/>
        <div class='short_explanation'>* required fields</div>
        <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
        <div class='container'>
        <label for='username1' >UserName*:</label><br/>
        <input type='text' name='username1' id='username1' list="namlist"
        value='<?php echo $fgmembersite->SafeDisplay('username1') ?>' maxlength="50" /><br/>

        <datalist id="namlist"></datalist>
        <script>
        vallist('PS_NM','namlist');
        </script>

        <span id='login_username_errorloc' class='error'></span>
        </div>
        <div class='container'>
        <label for='password1' >Password*:</label><br/>
        <input type='password' name='password1' id='password1' maxlength="50" /><br/>
        <span id='login_password_errorloc' class='error'></span>
        </div>
        <div class='container'>
        <input type='submit' name='Submit1' value='Submit' id='button1' />
        </div>
        <tm class="toolmas">
        <div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>
        <tt class="tooltex"> <?php echo "hint:".$fgmembersite->gethint();?> </tt>
        </tm>
      </fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->


</div>
</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->

</body>
</html>