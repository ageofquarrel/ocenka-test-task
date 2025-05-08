<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstimateController extends AbstractController
{
    #[Route('/estimate', name: 'app_estimate')]
    public function index(): Response
    {
        return $this->render('estimate/index.html.twig', [
            'controller_name' => 'EstimateController',
        ]);
    }
}
