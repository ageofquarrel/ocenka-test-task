<?php

declare(strict_types=1);

namespace App\Dto\Estimate;

use App\Entity\Estimate;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class StoreEstimateDto
{
    public function __construct(
        public readonly FormInterface $form,
        public readonly UserInterface $user,
        public readonly Estimate $estimate,
    ) {
    }
}