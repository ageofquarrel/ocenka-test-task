<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Добавление тестовых пользователей.
 */
class UserFixtures extends Fixture
{
    /**
     * Инициализация.
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    /**
     * Загрузка данных.
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword($user, '123456');
        $user->setPassword($hashedPassword);
        $user->onPrePersist();

        $manager->persist($user);
        $manager->flush();
    }
}