<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;




class RaceController extends AbstractController
{
    #[Route('/race', name: 'app_race')]
    public function index(): Response
    {
        return $this->render('race/index.html.twig', [
            'controller_name' => 'RaceController',
        ]);
    }


    protected $request;


    #[Route('/show', name: 'show')]
    public function show(RequestStack $request_stack): Response
    {
        $request = $request_stack->getCurrentRequest();
        $data = json_decode($request->getContent(), true);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        return $this->render('race/index.html.twig', [
            'controller_name' => 'RaceController',
        ]);
    
    
}
}