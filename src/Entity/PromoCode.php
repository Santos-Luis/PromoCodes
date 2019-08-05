<?php

namespace App\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromoCodeRepository")
 * @ORM\Table(name="PromoCode")
 */
class PromoCode
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $discountPercentage;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $expirationDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $createdBy;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $editedAt;

    public function __construct(
        string $id,
        string $owner,
        int $discountPercentage,
        DateTime $expirationDate,
        string $createdBy,
        DateTime $editedAt = null
    ) {
        $this->id = $id;
        $this->owner = $owner;
        $this->discountPercentage = $discountPercentage;
        $this->expirationDate = $expirationDate;
        $this->createdBy = $createdBy;
        $this->createdAt = new DateTime('now', new DateTimeZone('Europe/Lisbon'));
        $this->editedAt = $editedAt ?? $this->createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getDiscountPercentage(): int
    {
        return $this->discountPercentage;
    }

    public function getExpirationDate(): DateTime
    {
        return $this->expirationDate;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getEditedAt(): DateTime
    {
        return $this->editedAt;
    }

    public function setOwner(string $owner): void
    {
        $this->owner = $owner;
    }

    public function setDiscountPercentage(int $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function setExpirationDate(DateTime $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setEditedAt(DateTime $editedAt): void
    {
        $this->editedAt = $editedAt;
    }


}
