<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Estimate;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Форма создания оценки.
 */
class EstimateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => function (Service $service) {
                    return sprintf('%s', $service->getName());
                },
                'choice_attr' => function (Service $service) {
                    return ['data-price' => $service->getPrice()->getAmount() / 100];
                },
                'label' => 'Сервис',
                'placeholder' => 'Выберите услугу',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Цена',
                'currency' => 'RUB',
                'disabled' => true,
                'required' => false,
                'mapped' => false,
                'attr' => ['readonly' => true],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Подтвердить',
            ]);
    }

    /**
     * Опции формы.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estimate::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'estimate_form',
        ]);
    }
}
