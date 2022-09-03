<?php

namespace App\Service;

use App\Entity\Result;
use App\Repository\ResultRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Regex;

class CreateDbEntryServiceResult //extends RaceService  ?mozda
{
     private ResultRepository $resultRepository;
     
     public function __construct(ResultRepository $raceRepository)
     {
          $this->raceRepository = $raceRepository;
     }
}

// public function uploadAndInjectCSV(Request $request, EntityManager $entityManager)
// {
//      //Form creation ommited
//      $form->handleRequest($request);
     
//      if ($form->isSubmitted() && $form->isValid()) { 
//           $file = $form->get('csv_file')->getData();
          
//           //Opent the file
//           if (($handle = fopen($file->getPathName(), "r")) !==false){

//                //Read and procss the lines
//                //Skip the first line if hte file contains a header
//                while (($data = fgetcsv($handle)) !==false) {
//                     //Do the processing: Map line to entity, validate if needed
//                     $result = new Result;

//                     $result -> setFullName($data[0]);
//                     $result -> setRaceTime($data[1]);
//                     $result -> setDistance($data[2]);
//                     $result-> setPlacement($data[3]);

//                     $em->persist($result);
//                     $this->resultRepository->save($result);

//                     return $result;
//                }

//                fclose($handle);
//                $em->flush();
               
//           }

//      }
// }