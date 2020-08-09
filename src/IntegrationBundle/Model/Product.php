<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Model;

/**
 * Class Product
 * @package IntegrationBundle\Model
 */
class Product
{
    use IntegrationTrait;

    /** @var string */
    private $name;

    /** @var bool */
    private $isSimple;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $shortDescription;

    /** @var array */
    private $productVariants;

    /** @var int|null */
    private $taxon;

    /** @var string|null */
    private $taxonName;

    /** @var int|null */
    private $onHand;

    /** @var int|null */
    private $priceRegular;

    /** @var int|null */
    private $pricePromotion;

    /** @var int|null */
    private $originalPrice;

    /** @var array */
    private $attributes;

    /** @var bool */
    private $disabled;

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param bool $isSimple
     * @return Product
     */
    public function isSimple(bool $isSimple): Product
    {
        $this->isSimple = $isSimple;
        return $this;
    }

    /**
     * @param string|null $description
     * @return Product
     */
    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }


    /**
     * @param string|null $shortDescription
     * @return Product
     */
    public function setShortDescription(?string $shortDescription): Product
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @param ProductVariant $productVariant
     * @return Product
     */
    public function addProductVariant(ProductVariant $productVariant): Product
    {
        $this->productVariants[] = $productVariant;
        return $this;
    }

    /** @return array */
    public function getProductVariants(): array
    {
        return $this->productVariants;
    }

    /**
     * @param int|null $taxon
     * @return Product
     */
    public function setTaxon(?int $taxon): Product
    {
        $this->taxon = $taxon;
        return $this;
    }

    /** @return string|null */
    public function getTaxonName(): ?string
    {
        return $this->taxonName;
    }

    /** @return int|null */
    public function getPricePromotion(): ?int
    {
        return $this->pricePromotion;
    }

    /**
     * @param null|int $pricePromotion
     * @return Product
     */
    public function setPricePromotion(?int $pricePromotion): Product
    {
        $this->pricePromotion = $pricePromotion;
        return $this;
    }

    /** @return int|null */
    public function getOriginalPrice(): ?int
    {
        return $this->originalPrice;
    }

    /**
     * @param null|int $originalPrice
     * @return Product
     */
    public function setOriginalPrice(?int $originalPrice): Product
    {
        $this->originalPrice = $originalPrice;
        return $this;
    }

    /**
     * @param string|null $taxonName
     * @return Product
     */
    public function setTaxonName(?string $taxonName): Product
    {
        $this->taxonName = $taxonName;
        return $this;
    }

    /**
     * @param int|null $onHand
     * @return Product
     */
    public function setOnHand(?int $onHand): Product
    {
        $this->onHand = $onHand;
        return $this;
    }

    /**
     * @param int|null $priceRegular
     * @return Product
     */
    public function setPriceRegular(?int $priceRegular): Product
    {
        $this->priceRegular = $priceRegular;
        return $this;
    }

    /**
     * @param Attribute $attribute
     * @return Product
     */
    public function addAttribute(Attribute $attribute): Product
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /** @return array */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }

    /** @return string|null */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /** @return string|null */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /** @return int|null */
    public function getTaxon(): ?int
    {
        return $this->taxon;
    }

    /** @return int|null */
    public function getOnHand(): ?int
    {
        return $this->onHand;
    }

    /** @return int|null */
    public function getPriceRegular(): ?int
    {
        return $this->priceRegular;
    }

    /** @return bool */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return Product
     */
    public function setDisabled(bool $disabled): Product
    {
        $this->disabled = $disabled;
        return $this;
    }
}
