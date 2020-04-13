<?php

namespace App\Repository;

use App\Entity\Inventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

    public function dropAll()
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Inventory'
        );
        return $query->execute();
    }

    public function getTotalInventoryItems()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT SUM(quantity) AS quantity FROM inventory
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

}
