<?php

namespace App\Service;

use App\Entity\Race;
use App\Repository\RaceRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateDbEntryServiceRace extends RaceService
{
     private RaceRepository $raceRepository;
     
     public function __construct(RaceRepository $raceRepository)
     {
          $this->raceRepository = $raceRepository;
     }


public function createDbEntry()
{
     $race = new Race;

     $raceName = $_POST['inputRaceName1'];
     $date     = $_POST['inputDate1'];
     
     
     $race->setRaceName($raceName);
     $race->setDate($date);
     
     $this->raceRepository->save($race);

     return $race;
     
}

}