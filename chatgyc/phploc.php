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
?>