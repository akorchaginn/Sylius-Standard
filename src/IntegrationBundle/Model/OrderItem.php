<?php


namespace IntegrationBundle\Model;

/**
 * Class OrderItem
 * @package IntegrationBundle\Model
 */
class OrderItem
{
    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $variantId;

    /**
     * @var null|string
     */
    private $variantId1c;

    /**
     * @var int
     */
    private $productId;

    /**
     * @var null|string
     */
    private $productId1c;

    /**
     * @var int
     */
    private $price;

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

    /**
     * @param int $productId
     * @return OrderItem
     */
    public function setProductId(int $productId): OrderItem
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @param int $price
     * @return OrderItem
     */
    public function setPrice(int $price): OrderItem
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param null|string $productId1c
     * @return OrderItem
     */
    public function setProductId1c(?string $productId1c): OrderItem
    {
        $this->productId1c = $productId1c;
        return $this;
    }

    /**
     * @param null|string $variantId1c
     * @return OrderItem
     */
    public function setVariantId1c(?string $variantId1c): OrderItem
    {
        $this->variantId1c = $variantId1c;
        return $this;
    }

}