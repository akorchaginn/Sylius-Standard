<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 16.10.2018
 * Time: 17:36
 */

namespace AppBundle\Entity;

use Sylius\Component\Core\Model\OrderItem as ParentOrderItem;
use AppBundle\Entity\OrderItemInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class OrderItem
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sylius_order_item")
 */
class OrderItem extends ParentOrderItem implements OrderItemInterface
{
    /**
     * @var int
     * @ORM\Column(name="original_price", type="integer", nullable=false)
     */
    protected $original_price = 0;

    /**
     * @return int
     */
    public function getOriginalPrice(): int
    {
        return $this->original_price;
    }

    /**
     * @param int $original_price
     */
    public function setOriginalPrice(int $original_price): void
    {
        $this->original_price = $original_price;
    }


}