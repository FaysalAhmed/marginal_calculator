<?php
/**
 * Sell Repository
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

use App\Entity\Sell;
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
 * @method Sell|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sell|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sell[]    findAll()
 * @method Sell[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SellRepository extends ServiceEntityRepository
{
    /**
     * SellRepository constructor.
     *
     * @param ManagerRegistry $registry manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sell::class);
    }

    /**
     * Drop all data from table
     *
     * @return mixed
     */
    public function dropAll()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Sell AS sell'
        );

        return $query->execute();
    }

    /**
     * Get total profit from sells
     *
     * @return bool|mixed
     */
    public function getTotalProfit()
    {
        try {
            $conn = $this->getEntityManager()->getConnection();
            $sql = '
        SELECT SUM(profit) AS profit FROM sell
        ';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetch();

            return $res['profit'];
        } catch (DBALException $e) {
            return false;
        }
    }
}
