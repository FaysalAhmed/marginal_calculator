<?php

/**
 * Inventory Repository
 *
 * PHP version 7
 *
 * @category Repository
 *
 * @package App\Repository
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Repository;

use App\Entity\Inventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\Persistence\ManagerRegistry;

/**
 *  Inventory Repository class
 *
 * PHP version 7
 *
 * @category Repository
 *
 * @package App\Repository
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 *
 * @method Inventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    /**
     * InventoryRepository constructor.
     *
     * @param ManagerRegistry $registry manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

    /**
     * Drop all from table
     *
     * @return mixed
     */
    public function dropAll()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Inventory AS inventory'
        );

        return $query->execute();
    }

    /**
     * Get total quantities of inventory
     *
     * @return bool|int
     */
    public function getTotalRemainingItems()
    {
        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = '
        SELECT SUM(remaining) AS remaining FROM inventory
        ';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetch();

            return $res['remaining'];
        } catch (DBALException $e) {
            return false;
        }
    }

    /**
     * Find items where remaining > 0
     *
     * @return mixed
     */
    public function findAllByRemainingItems()
    {
        $conn = $this->getEntityManager()->getConnection();
        $em = $this->getEntityManager();
        return $em->createQuery(
            "
select inventory from App\Entity\Inventory inventory where inventory._remaining > 0 
"
        )->getResult();
    }
}
