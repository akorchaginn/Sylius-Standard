<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Model;

class ProductVariant
{
    use IntegrationTrait;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int
     */
    private $onHand;

    /**
     * @param string|null $name
     * @return ProductVariant
     */
    public function setName(?string $name): ProductVariant
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $price
     * @return ProductVariant
     */
    public function setPrice(int $price): ProductVariant
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param int $onHand
     * @return ProductVariant
     */
    public function setOnHand(int $onHand): ProductVariant
    {
        $this->onHand = $onHand;
        return $this;
    }


}