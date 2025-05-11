<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Сущность пользователя.
 */
#[ORM\Entity]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Идентификатор пользователя.
     *
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    /**
     * Email.
     *
     * @var string
     */
    #[ORM\Column(unique: true)]
    private string $email;

    /**
     * Пароль.
     *
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $password;

    /**
     * Роли.
     *
     * @var array
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $deletedAt = null;

    /**
     * Получение id пользователя.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Установка id пользователя.
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Получение email пользователя.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Установка email пользователя.
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Получение ролей.
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * Мягкое удаление.
     */
    public function softDelete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
    }

    /**
     * Получение признака удаления.
     */
    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    /**
     * Установка created_at.
     */
    public function setCreatedAt(DateTimeImmutable $dateTime): self
    {
        $this->createdAt = $dateTime;

        return $this;
    }

    /**
     * Установка updated_at.
     */
    public function setUpdatesdAt(DateTimeImmutable $dateTime): self
    {
        $this->createdAt = $dateTime;

        return $this;
    }
}