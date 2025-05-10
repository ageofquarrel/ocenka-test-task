<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Форма авторизации.
 */
class LoginType extends AbstractType
{
    /**
     * Создание формы.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Email не может быть пустым.']),
                    new Assert\Email(['message' => 'Введите корректный email.']),
                ],
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Пароль не может быть пустым.']),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Пароль должен содержать минимум {{ limit }} символов.',
                    ]),
                ],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Войти'])
            ->add('_target_path', HiddenType::class, [
                'mapped' => false,
                'data' => '/dashboard',
            ]);
    }

    /**
     * Убирает префикс формы.
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
