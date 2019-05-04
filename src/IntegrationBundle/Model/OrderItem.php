<?php


namespace IntegrationBundle\Model;


class OrderItem
{
    use IntegrationTrait;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $variantId;

    /**
     * @param int $quantity
     * @return OrderItem
     */
    public function setQuantity(int $quantity): OrderItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @param int $variantId
     * @return OrderItem
     */
    public function setVariantId(int $variantId): OrderItem
    {
        $this->variantId = $variantId;
        return $this;
    }

}