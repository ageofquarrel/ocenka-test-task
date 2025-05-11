<?php

declare(strict_types=1);

namespace App\Service\Estimate;

use Symfony\Component\Form\FormInterface;

/**
 * Класс для валидации формы оценки.
 */
final class EstimateValidator
{
    /**
     * Сообщение об ошибке при вводе email.
     *
     * @var string
     */
    private const EMAIL_ERROR = 'Введите корректный email.';

    /**
     * Сообщение об ошибке при выборе услуги.
     *
     * @var string
     */
    private const SERVICE_ERROR = 'Выберите услугу.';

    /**
     * Выполнение валидации.
     */
    public function validate(FormInterface $form): array
    {
        $errors = [];

        $email = $form->get('email')->getData();
        $service = $form->get('service')->getData();

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = self::EMAIL_ERROR;
        }

        if (empty($service)) {
            $errors[] = self::SERVICE_ERROR;
        }

        return $errors;
    }
}