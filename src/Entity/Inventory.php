<?php
/**
 * Inventory file
 *
 * PHP version 7
 *
 * @category Entity
 *
 * @package App\Entity
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
namespace App\Entity;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Inventory Class
 *
 * PHP version 7
 *
 * @category Entity
 *
 * @package App\Entity
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 *
 * @ORM\Entity(repositoryClass="App\Repository\InventoryRepository")
 */
class Inventory
{
    /**
     * ID
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Quantity
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * Price
     *
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Remaining items from the lot
     *
     * @ORM\Column(name="remaining", type="integer")
     */
    private $_remaining;

    /**
     * Created at
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $now = new DateTime('now');
        $now->setTimezone(new DateTimeZone('Asia/Dhaka'));
        $this->setCreatedAt($now);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRemaining(): ?int
    {
        return $this->_remaining;
    }

    public function setRemaining(int $remaining): self
    {
        $this->_remaining = $remaining;

        return $this;
    }



    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
