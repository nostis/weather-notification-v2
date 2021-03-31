<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=NotificationWish::class, inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $notificationWish;

    /**
     * @ORM\OneToMany(targetEntity=EmailNotification::class, mappedBy="notification")
     */
    private $emailNotifications;

    public function __construct()
    {
        $this->emailNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotificationWish(): ?NotificationWish
    {
        return $this->notificationWish;
    }

    public function setNotificationWish(?NotificationWish $notificationWish): self
    {
        $this->notificationWish = $notificationWish;

        return $this;
    }

    /**
     * @return Collection|EmailNotification[]
     */
    public function getEmailNotifications(): Collection
    {
        return $this->emailNotifications;
    }

    public function addEmailNotification(EmailNotification $emailNotification): self
    {
        if (!$this->emailNotifications->contains($emailNotification)) {
            $this->emailNotifications[] = $emailNotification;
            $emailNotification->setNotification($this);
        }

        return $this;
    }

    public function removeEmailNotification(EmailNotification $emailNotification): self
    {
        if ($this->emailNotifications->removeElement($emailNotification)) {
            // set the owning side to null (unless already changed)
            if ($emailNotification->getNotification() === $this) {
                $emailNotification->setNotification(null);
            }
        }

        return $this;
    }
}
