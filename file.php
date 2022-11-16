<?php
  
    //var_dump($_FILES);

     
    echo realpath($_FILES["file_src"]["tmp_name"]);
     

    $name = fopen($_FILES["file_src"]["tmp_name"], 'r');
 
    echo "File actual name is $name";

  
?>