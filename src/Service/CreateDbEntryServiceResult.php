<?php

namespace App\Service;

use App\Entity\Race;
use App\Entity\Result;
use App\Repository\ResultRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManager;
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





public function uploadAndInjectCSV() 
{

     $file = $_FILES['csv_file'];

     $race = new Race;

     $raceName = $_POST['inputRaceName1'];
     $date     = $_POST['inputDate1'];
     
     
     $race->setRaceName($raceName);
     $race->setDate($date);
     
     $this->raceRepository->save($race);


     // echo $raceName;
     // return $raceName;
     foreach ($file as $data){
              $result = new Result;
                    $result ->setRace($race);
                    $result-> setFullName('meri');
                    $result -> setRaceTime(new \DateTime());
                    $result -> setDistance(100);
                    $result-> setPlacement(1); 
                    
                    $this->resultRepository->save($result);
     }

     //Form creation ommited
     // $form->handleRequest($request);
     
     // if ($form->isSubmitted() && $form->isValid()) { 
          // $file = $form->get('csv_file')->getData();
          
          //Opent the file
          // if (($handle = fopen($file->getPathName(), "r")) !==false){

               //Read and procss the lines
               //Skip the first line if hte file contains a header
               // while (($data = fgetcsv($file)) !==false) {
               //      //Do the processing: Map line to entity, validate if needed
               //      $result = new Result;

               //      $result -> setFullName($data[0]);
               //      $result -> setRaceTime($data[1]);
               //      $result -> setDistance($data[2]);
               //      $result-> setPlacement($data[3]);

               //      // $em->persist($result);
               //      $this->resultRepository->save($result);

               //      return $result;
               // }

               // fclose($handle);
               // $em->flush();
               
          }

     }

