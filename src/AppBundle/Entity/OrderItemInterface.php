<?php
/**
 * Created by PhpStorm.
 * User: akorc_000
 * Date: 16.10.2018
 * Time: 18:24
 */

namespace AppBundle\Entity;

use Sylius\Component\Core\Model\OrderItemInterface as BaseOrderItemInterface;

interface OrderItemInterface extends BaseOrderItemInterface
{
    /**
     * @return int
     */
    public function getOriginalPrice(): int;

    /**
     * @param int $original_price
     */
    public function setOriginalPrice(int $original_price): void;

}