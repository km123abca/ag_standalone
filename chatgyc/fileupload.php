<?php

function sanitizedb($fil="inbox.txt")
  {
  $fil='boxes/'.$fil;
  $file_save=fopen($fil,"w+");
  flock($file_save,LOCK_EX);
  fputs($file_save,"");
  
  flock($file_save,LOCK_UN);
  fclose($file_save);
  }
function store2db($contentt,$fil="inbox.txt")
  {
  $fil='boxes/'.$fil;
  $file_save=fopen($fil,"a+");
  flock($file_save,LOCK_EX);
  fputs($file_save,$contentt."\n");
  
  flock($file_save,LOCK_UN);
  fclose($file_save);
  }

function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
        //echo 'clle';
    }

        if (isset($_FILES["fileToUpload"]))
        {
        $us_nm='none found';
        if (isset($_POST['us_nm']))  $us_nm=$_POST['us_nm'];
        sanitizedb();
        store2db($us_nm);
        $ho=getHostByName(getHostName());
        $port=':'.$_SERVER['SERVER_PORT'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        
        // Check if file already exists
        if (file_exists($target_file)) 
               {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        RedirectToURL("index.php?us_nm=".$us_nm."&linn=http://$ho$port/ag/chatgyc/".$target_file);
               }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 50000000) 
            {
        echo "<br>Sorry, your file is too large.".$_FILES['fileToUpload']['size']." is the size";
        $uploadOk = 0;
            }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf") 
            {
        echo "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
            }

        if ($uploadOk == 0) 
            {
        echo "<br>Sorry, your file was not uploaded.";
        RedirectToURL("index.php?linn=#");

            } 
        else 
            {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                    {
        echo "The file ". $target_file. " has been uploaded. here is the link ";
        echo "<br>"."<a href='http://localhost/ag/chatgyc/testing/".$target_file."'>link</a>";
       
        RedirectToURL("index.php?us_nm=".$us_nm."&linn=http://$ho$port/ag/chatgyc/".$target_file);
                    } 
        else        {
        echo "Sorry, there was an error uploading your file.";
                    }
            }

        }


?>

<head>
</head>

<body>
<!--
<form action='fileupload.php' method="post" enctype="multipart/form-data">
<input type="file" name="fileToUpload" id="fileToUpload" class='labtdx' >
<input type="submit" value="Upload" name="submit" class='labtdx'>
</form>
-->
</body>