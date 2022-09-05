<?php

namespace App\Service;


use App\Entity\Race;
use App\Entity\Result;
use App\Repository\ResultRepository;
use App\Repository\RaceRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use mysqli;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Regex;

class CreateDbEntryServiceResult extends RaceService  
{
     private ResultRepository $resultRepository;
     private RaceRepository $raceRepository;
     
     public function __construct(ResultRepository $resultRepository, RaceRepository $raceRepository)
     {
          $this->resultRepository = $resultRepository;
          $this->raceRepository = $raceRepository;

     }


//      public function upload_csv()
//      {
//           $display_table =$_REQUEST['csv_file'] ?? null;
//           return $display_table;
//      }

// }



public function uploadAndInjectCSV() 
{
     include_once 'db.php';
     $content = $_FILES['csv_file'];
     // fgetcsv($content);
     // file_get_contents($_FILES['csv_file']['tmp_name']);
     // $content = fgetcsv($_FILES['csv_file']['tmp_name']);


     $race = new Race;

     $raceName = $_POST['inputRaceName1'];
     $date     = $_POST['inputDate1'];
     
     
     $race->setRaceName($raceName);
     $race->setDate($date);
     
     $this->raceRepository->save($race);

       // Allowed mime types
    $fileMimes = array(
     'text/x-comma-separated-values',
     'text/comma-separated-values',
     'application/octet-stream',
     'application/vnd.ms-excel',
     'application/x-csv',
     'text/x-csv',
     'text/csv',
     'application/csv',
     'application/excel',
     'application/vnd.msexcel',
     'text/plain'
 );


     if (isset($_POST['upload']) && (!empty($_FILES['csv_file']) && in_array($_FILES['csv_file']['type'], $fileMimes)))
     {

          $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');  
          fgetcsv($csvFile);             
          // fgetcsv($content);

               while(($getData = fgetcsv($csvFile, 1000, ",")) !==FALSE)
               {

                     $fullName = $getData[0];
                     $distance = $getData[1];
                  
                     
                     $str_time = $getData[2];

                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

                    $raceTime = $time_seconds ;

                     
                    $result = new Result;
                    $result ->setRace($race);
                    $result-> setFullName($fullName);
                    $result-> setFinishTime($raceTime);
                    $result -> setDistance($distance);
                    $result-> setPlacement(1); 
                    
                    $this->resultRepository->save($result);
                    // $fullName = $getData[0];
                    // $distance = $getData[1];
                    // $raceTime = $getData[2];


                    // $query = "SELECT id FROM users WHERE fullName = '" . $getData[0] . "'";
                    // $check = mysqli_query($conn, $query);

                    // if($check -> num_rows > 0)
                    // {
                    //      mysqli_query($conn, "UPDATE RESULT SET full_name = ' " .$fullName. " ' , distance = ' " . $distance . " ', race_time = ' " . $raceTime . " '");
                    // }            
                    // else
                    // {
                    //      mysqli_query($conn, "(INSERT INTO users (full_name, race_time, distance) VALUES ('" . $fullName. "', '" .$raceTime. "', '" .$distance. "')");                
                                    

                    }
                    
                    fclose($csvFile);
             

               }
               
     }
     
     }



     // // Form creation ommited
    
     // // $form->handleRequest($request);
     
     // // if ($form->isSubmitted() && $form->isValid()) { 
     // //      $file = $form->get('csv_file')->getData();
          
     // //      // Opent the file
     //      if (($handle = fopen($file->getPathName(), "r")) !==false){

     //           // Read and procss the lines
     //           // Skip the first line if hte file contains a header
     //           while (($data = fgetcsv($file)) !==false) {
     //                //Do the processing: Map line to entity, validate if needed
     //                $result = new Result;

     //                $result -> setFullName($data[0]);
     //                $result -> setRaceTime($data[1]);
     //                $result -> setDistance($data[2]);
     //                $result-> setPlacement($data[3]);

     //                // $em->persist($result);
     //                $this->resultRepository->save($result);

     //                return $result;
     //           }

     //           fclose($handle);
     //           $em->flush();
               
     //      }

     


