<?php

namespace App\Service;


use App\Entity\Race;
use App\Entity\Result;
use App\Repository\ResultRepository;
use App\Repository\RaceRepository;


class CreateDbEntryServiceResult extends RaceService  
{
     private ResultRepository $resultRepository;
     private RaceRepository $raceRepository;
     
     public function __construct(ResultRepository $resultRepository, RaceRepository $raceRepository)
     {
          $this->resultRepository = $resultRepository;
          $this->raceRepository = $raceRepository;

     }


public function uploadAndInjectCSV() 
{
    
     $content = $_FILES['csv_file'];
    

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
                                                  
                    }
                    
                    fclose($csvFile);
             

               }
               
     }
     
     }
