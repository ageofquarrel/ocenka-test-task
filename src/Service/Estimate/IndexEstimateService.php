<?php

declare(strict_types=1);

namespace App\Service\Estimate;

use App\Entity\Estimate;
use App\Repository\EstimateRepository;
use LogicException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Сервис для обработки оценки.
 */
final class IndexEstimateService
{
    /**
     * Инициализация.
     */
    public function __construct(
        private EstimateRepository $estimateRepository,
        private RequestStack $requestStack,
    ) {
    }

    /**
     * Запуск сервиса.
     */
    public function run(FormInterface $form, UserInterface $user, Estimate $estimate): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $form->handleRequest($request);
        $errors = [];

        if ($form->isSubmitted()) {
            $service = $form->get('service')->getData();
            $email = $form->get('email')->getData();

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Введите корректный email.';
            }

            if (empty($service)) {
                $errors[] = 'Выберите услугу.';
            }

            if (empty($errors) && $form->isValid()) {
                if (!$user) {
                    throw new LogicException('Пользователь не найден. Убедитесь, что он авторизован.');
                }

                $estimate->setUser($user);

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