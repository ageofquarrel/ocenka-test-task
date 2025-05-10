<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EstimateRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

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
     * @var Service
     */
    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(
        name: 'service_id',
        referencedColumnName: 'id',
        nullable: false
    )]
    private Service $service;

    /**
     * Email клиента.
     *
     * @var string
     */
    #[ORM\Column]
    private string $email;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTime $updatedAt;

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
}
