<?php

namespace App\Service;


class ImportCsvService
{
 function csvImportToMysql()
 {
 if(isset($_POST["upload"])){
    
    $filename=$_FILES["csv_file"]["tmp_name"];    
    
    if($_FILES["csv_file"]["size"] > 0)
     {
      
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {
             $sql = "INSERT into result (full_name, distance, race_time) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."')";
                   $result = mysqli_query($con, $sql);
        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"index.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"index.php\"
          </script>";
        }
           }
      
           fclose($file);  
     }
  }   
}
}
 ?>
