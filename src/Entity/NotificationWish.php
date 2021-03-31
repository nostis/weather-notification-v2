<?php

namespace App\Entity;

use App\Repository\NotificationWishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=NotificationWishRepository::class)
 */
class NotificationWish
{
    use TimestampableEntity;

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

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="notificationWish")
     */
    private $notifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

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

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setNotificationWish($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getNotificationWish() === $this) {
                $notification->setNotificationWish(null);
            }
        }

        return $this;
    }
}
