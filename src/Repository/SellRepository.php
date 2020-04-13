<?php

namespace App\Repository;

use App\Entity\Sell;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sell|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sell|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sell[]    findAll()
 * @method Sell[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SellRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sell::class);
    }

    public function dropAll()
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Sell'
        );
        return $query->execute();
    }

    public function getTotalProfit()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT SUM(profit) AS profit FROM sell
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }
}
