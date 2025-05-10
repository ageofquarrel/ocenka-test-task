<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Добавление тестовых сервисов.
 */
final class ServiceFixtures extends Fixture
{
    /**
     * Загрузка данных.
     */
    public function load(ObjectManager $manager): void
    {
        $services = [
            ['Оценка стоимости автомобиля', 100],
            ['Оценка стоимости квартиры', 200],
            ['Оценка стоимости бизнеса', 300],
        ];

        foreach ($services as [$name, $amount]) {
            $service = new Service();
            $service->setName($name);
            $service->setPrice($amount * 100);
            $service->onPrePersist();

            $manager->persist($service);
        }

        $manager->flush();
    }
}