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
    private $priceRegular;

    /**
     * @var int
     */
    private $pricePromotion;

    /**
     * @var int
     */
    private $onHand;

    /**
     * @var boolean|null
     */
    private $enabled;

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

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool|null $enabled
     * @return ProductVariant
     */
    public function setEnabled(?bool $enabled): ProductVariant
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return int
     */
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

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPriceRegular(): int
    {
        return $this->priceRegular;
    }

    /**
     * @return int
     */
    public function getOnHand(): int
    {
        return $this->onHand;
    }

    /**
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

}