<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Estimate;
use App\Form\EstimateType;
use App\Service\Estimate\IndexEstimateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Контроллер оценок.
 */
class EstimateController extends AbstractController
{
    /**
     * Страница добавления оценки.
     */
    #[Route('/dashboard', name: 'app_estimate', methods: ['GET', 'POST'])]
    public function index(Request $request, IndexEstimateService $service): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->render('error/access_denied.html.twig');
        }

        $estimate = new Estimate();
        $form = $this->createForm(EstimateType::class, $estimate);

        $errors = $service->run($form, $user, $estimate);

        return $this->render('estimate/index.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }
}
