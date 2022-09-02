<?php

namespace App\Controller;

use App\Entity\Race;
use App\Repository\RaceRepository;
use App\Repository\ResultRepository;
use App\Service\CreateDbEntryService;
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
    private CreateDbEntryService $createDbEntryService;
    private RaceRepository $raceRepository;
    private CreateTableService $createTableService;
    private ResultRepository $resultRepository;

    public function __construct(
        RaceService $raceService, 
        CreateDbEntryService $createDbEntryService,
        RaceRepository $raceRepository,
        CreateTableService $createTableService,
        ResultRepository $resultRepository)
        
    {
        $this->raceService = $raceService;
        $this->createDbEntryService = $createDbEntryService;
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

    #[Route('/upload', name: 'upload')]
    public function uploadFile()
    {
        $response = "";

        if($this->raceService->uploadFile()){

            $this->createDbEntryService->createDbEntry();

            $this->createTableService->execute();

            return $this->redirect(url:"/results");
        } else {
            $response = "Error";
        }
        return $response;

    }




    #[Route('/results', name: 'results')]
    public function results(): Response
    {
        return $this->render('/race/results.html.twig');
    }
 

    
    #[Route('/download-file/{id}')]
    public function downloadFile($id): BinaryFileResponse
    {
        $file = $this->raceRepository->find($id);

        return $this->file($_SERVER['DOCUMENT_ROOT']."/Downloads/".$file->getName());
    }


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



