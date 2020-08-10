<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Model;

/**
 * Class ProductVariant
 * @package IntegrationBundle\Model
 */
class ProductVariant
{
    use IntegrationTrait;

    /** @var string|null */
    private $name;

    /** @var int */
    private $priceRegular;

    /** @var int */
    private $pricePromotion;

    /** @var int|null */
    private $originalPrice;

    /** @var int */
    private $onHand;

    /** @var bool|null */
    private $disabled;

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
     * @param int $priceRegular
     * @return ProductVariant
     */
    public function setPriceRegular(int $priceRegular): ProductVariant
    {
        $this->priceRegular = $priceRegular;
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

    /** @return int */
    public function getPricePromotion(): int
    {
        return $this->pricePromotion;
    }

    /**
     * @param int $pricePromotion
     * @return ProductVariant
     */
    public function setPricePromotion(int $pricePromotion): ProductVariant
    {
        $this->pricePromotion = $pricePromotion;
        return $this;
    }

    /** @return string|null */
    public function getName(): ?string
    {
        return $this->name;
    }

    /** @return int */
    public function getPriceRegular(): int
    {
        return $this->priceRegular;
    }

    /** @return int|null */
    public function getOriginalPrice(): ?int
    {
        return $this->originalPrice;
    }

    /**
     * @param int|null $originalPrice
     * @return ProductVariant
     */
    public function setOriginalPrice(?int $originalPrice): ProductVariant
    {
        $this->originalPrice = $originalPrice;
        return $this;
    }

    /** @return int */
    public function getOnHand(): int
    {
        return $this->onHand;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled ?? false;
    }

    /**
     * @param bool|null $disabled
     * @return ProductVariant
     */
    public function setDisabled(?bool $disabled): ProductVariant
    {
        $this->disabled = $disabled;
        return $this;
    }

}
