<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;

/**
 * Сущность услуг для оценки.
 */
#[ORM\Entity]
#[ORM\Table(name: 'services')]
#[ORM\HasLifecycleCallbacks]
class Service
{
    /**
     * Валюта.
     */
    private const CURRENCY = 'RUB';

    /**
     * Текст ошибки при установке валюты.
     */
    private const ERROR_MESSAGE = 'Валюта должна быть указана в рублях.';

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
     * Название услуги.
     *
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * Стоимость услуги (в копейках).
     *
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    private int $price;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * Получение id услуги.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Получение id услуги.
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Получение названия услуги.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Установка названия услуги.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Получение стоимости услуги.
     */
    public function getPrice(): Money
    {
        return new Money($this->price, new Currency(self::CURRENCY));
    }

    /**
     * Установка стоимости услуги.
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

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
}
