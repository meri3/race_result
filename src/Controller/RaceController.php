<?php

namespace App\Controller;


use App\Repository\RaceRepository;
use App\Repository\ResultRepository;
use App\Service\CreateDbEntryServiceResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class RaceController extends AbstractController
{

    private CreateDbEntryServiceResult $createDbEntryServiceResult;
    private RaceRepository $raceRepository;
    private RaceRepository $resultRepository;

    public function __construct(
        
        CreateDbEntryServiceResult $createDbEntryServiceResult,
        RaceRepository $raceRepository,
        RaceRepository $resultRepository
        )
        
    {
       
        $this->createDbEntryServiceResult = $createDbEntryServiceResult;
        $this->raceRepository = $raceRepository;
        $this->resultRepository = $resultRepository;

      
    }
    
    #[Route('/race', name: 'app_race')]
    public function index(): Response
    {
        $files = $this->raceRepository->findAll();
    
        return $this->render('race/index.html.twig',        
        [
            'controller_name' => 'RaceController',
            "files"=>$files,
          

        ]);
    }

  
    #[Route('/upload', name: 'upload')]
    public function uploadFile()
    {
        $response = "";
       
            $this->createDbEntryServiceResult->uploadAndInjectCSV();
            
            return $this->redirect(url:"/results");

        return $response;

    }
    
    #[Route('/results', name: 'results')]
    public function results(): Response
    {
        $files = $this->raceRepository->findAll();
        

        return $this->render('/race/results.html.twig',  [
            'controller_name' => 'RaceController',
            "files"=>$files
            
        ]);
    }


    #[Route('/results/{id}', methods: ['GET'], name: 'show_results')]
    public function singleRace($id): Response
    {
        $file = $this->raceRepository->find($id);
        $files = $this->raceRepository->findAll();

        
        return $this->render('/race/results.html.twig', [
            'file' => $file,
            'files'=> $files
        ]);
    }

    #[Route('/download-file/{id}')]
    public function downloadFile($id): Response
    {
        $file = $this->raceRepository->find($id);

        return $this->file($_SERVER['DOCUMENT_ROOT']."/Downloads/".$file->getraceName());
    }
}

