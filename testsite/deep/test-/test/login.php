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

              #login
              {
                
                left:4px;
                top:4px;
              }

              #login2
              {
                
                left:4px;
                top:4px;
              }

              #jumbo
              {
                position: relative;
                top:100px;
                left:100px;
               /* border:2px solid black;*/
                width:70%;
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
</head>
<body>

<!-- Form Code Start -->
<div id='jumbo'>
<div id='fg_membersite'>

<form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'  >
      <fieldset>
        <legend>Login</legend>
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

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","Please provide your username");
    
    frmvalidator.addValidation("password","req","Please provide the password");

// ]]>
</script>
</div>


<div id='fg_membersite' style="float:right;">

<form id='login2' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'  >
      <fieldset>
        <legend>Login</legend>
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

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","Please provide your username");
    
    frmvalidator.addValidation("password","req","Please provide the password");

// ]]>
</script>
</div>
</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->

</body>
</html>