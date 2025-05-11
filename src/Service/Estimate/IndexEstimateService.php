<?php

declare(strict_types=1);

namespace App\Service\Estimate;

use App\Dto\Estimate\StoreEstimateDto;
use App\Repository\Estimate\EstimateRepository;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Сервис для обработки оценки.
 */
final class IndexEstimateService
{
    /**
     * Инициализация.
     */
    public function __construct(
        private readonly EstimateRepository $estimateRepository,
        private readonly RequestStack $requestStack,
        private readonly EstimateValidator $estimateValidator,
    ) {
    }

    /**
     * Запуск сервиса.
     */
    public function run(StoreEstimateDto $dto): array
    {
        $form = $dto->form;
        $estimate = $dto->estimate;

        $request = $this->requestStack->getCurrentRequest();
        $form->handleRequest($request);
        $errors = [];

        if ($form->isSubmitted()) {
            $errors = $this->estimateValidator->validate($form);

            if (empty($errors) && $form->isValid()) {
                $estimate->setUser($dto->user);

                $this->estimateRepository->add($estimate, true);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Оценка успешно добавлена.');

                return $errors;
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $request->getSession()
                        ->getFlashBag()
                        ->add('error', $error);
                }
            }
        }

        return $errors;
    }
}