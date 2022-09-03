<?php

namespace App\Controller;

use App\Entity\Race;
use App\Repository\RaceRepository;
use App\Repository\ResultRepository;
use App\Service\CreateDbEntryServiceResult;
use App\Service\CreateDbEntryServiceRace;
use App\Service\RaceService;
use App\Service\CreateTableService;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\BinaryFileResponse;



class RaceController extends AbstractController
{

    private RaceService $raceService;
    private CreateDbEntryServiceRace $createDbEntryServiceRace;
    private CreateDbEntryServiceResult $createDbEntryServiceResult;
    private RaceRepository $raceRepository;
    private CreateTableService $createTableService;
    private ResultRepository $resultRepository;

    public function __construct(
        RaceService $raceService, 
        CreateDbEntryServiceRace $createDbEntryServiceRace,
        CreateDbEntryServiceResult $createDbEntryServiceResult,
        RaceRepository $raceRepository,
        CreateTableService $createTableService,
        ResultRepository $resultRepository)
        
    {
        $this->raceService = $raceService;
        $this->createDbEntryServiceRace = $createDbEntryServiceRace;
        $this->createDbEntryServiceResult = $createDbEntryServiceResult;
        $this->raceRepository = $raceRepository;
        $this->createTableService = $createTableService;
        $this->resultRepository = $resultRepository;
    }

    
    #[Route('/race', name: 'app_race')]
    public function index(): Response
    {
        $files = $this->raceRepository->findAll();

        return $this->render('race/index.html.twig', 
        
        [
            'controller_name' => 'RaceController',
            "files"=>$files
        ]);
    }

    // #[Route('/upload', name: 'upload')]
    // public function uploadFile()
    // {
    //     $response = "";

    //     if($this->raceService->uploadFile()){

    //         $this->createDbEntryServiceRace->createDbEntry();

    //         // $this->createTableService->execute($input, $output);

    //         return $this->redirect(url:"/results");
    //     } else {
    //         $response = "Error";
    //     }
    //     return $response;

    // }

    #[Route('/upload', name: 'upload')]
    public function uploadFile()
    {
        $response = "";

        if($this->raceService->uploadFile()){

            $this->createDbEntryServiceResult->uploadAndInjectCSV();

            // $this->createTableService->execute($input, $output);

            return $this->redirect(url:"/results");
        } else {
            $response = "Error";
        }
        return $response;

    }

    // #[Route('/results', name: 'csv_file')]
    // public function readCSV(): BinaryFileResponse
    // {
    //     $csvFile = file('Downloadsresults.csv');
    //     $data = [];
    //     foreach ($csvFile as $line){
    //         $data[] = str_getcsv($line);
            
    //         return $this-> $csvFile;
    //     }

    //     // return new Response(
    //     //     'There are no jobs in the database', 
    //     //     Response::HTTP_ACCEPTED
    //     // );
    // }
    


    #[Route('/results', name: 'results')]
    public function results(): Response
    {
        $files = $this->raceRepository->findAll();
        $file = $this->raceRepository->findAll();

        return $this->render('/race/results.html.twig',  [
            'controller_name' => 'RaceController',
            "files"=>$files,
            "file"=>$file
        ]);
    }
 

    
    #[Route('/download-file/{id}')]
    public function downloadFile($id): Response
    {
        $file = $this->raceRepository->find($id);

        return $this->file($_SERVER['DOCUMENT_ROOT']."/Downloads/".$file->getraceName());
    }

    // #[Route('/download-file/{id}')]
    // public function downloadFile1(): Response
    // {

    //     // $file = $this->

    //     return $this->render("/race/results.html.twig");
    // }


}

    // protected $request;


    // #[Route('/show', name: 'show')]
    // public function show(RequestStack $request_stack): Response
    // {
    //     $request = $request_stack->getCurrentRequest();
    //     $data = json_decode($request->getContent(), true);

    //     $response = new Response($data);
    //     $response->headers->set('Content-Type', 'application/json');

    //     return $response;
    //     return $this->render('race/index.html.twig', [
    //         'controller_name' => 'RaceController',
    //     ]);
    // }



