<?php

namespace App\Entity;

use App\Repository\NotificationWishRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationWishRepository::class)
 */
class NotificationWish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="notificationWishes")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notificationWishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $firstNotificationDateTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $notificationInterval;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFirstNotificationDateTime(): ?\DateTimeInterface
    {
        return $this->firstNotificationDateTime;
    }

    public function setFirstNotificationDateTime(\DateTimeInterface $firstNotificationDateTime): self
    {
        $this->firstNotificationDateTime = $firstNotificationDateTime;

        return $this;
    }

    public function getNotificationInterval(): ?int
    {
        return $this->notificationInterval;
    }

    public function setNotificationInterval(int $notificationInterval): self
    {
        $this->notificationInterval = $notificationInterval;

        return $this;
    }
}
