<?php

namespace App\Repository;

use App\Entity\NotificationWish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotificationWish|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationWish|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationWish[]    findAll()
 * @method NotificationWish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationWishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationWish::class);
    }
}
