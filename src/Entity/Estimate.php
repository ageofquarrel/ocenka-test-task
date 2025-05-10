<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EstimateRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Сущность оценок.
 */
#[ORM\Entity(repositoryClass: EstimateRepository::class)]
#[ORM\Table(name: 'estimates')]
#[ORM\HasLifecycleCallbacks]
class Estimate
{
    /**
     * Идентификатор.
     *
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * Услуга.
     *
     * @var ?Service
     */
    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(
        name: 'service_id',
        referencedColumnName: 'id',
        nullable: false
    )]
    #[Assert\NotNull(message: 'Выберите услугу.')]
    private ?Service $service;

    /**
     * Email клиента.
     *
     * @var string
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Email обязателен.')]
    #[Assert\Email(message: 'Укажите корректный email.')]
    private string $email;

    /**
     * Пользователь.
     *
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(
        name: 'user_id',
        referencedColumnName: 'id',
        nullable: false
    )]
    private UserInterface $user;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $deletedAt = null;

    /**
     * Получение id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Установка id.
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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
     * Получение сервиса.
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * Установка сервиса.
     */
    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Получение почты.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Установка почты.
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Получение пользователя.
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Установка пользователя.
     */
    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }
}
