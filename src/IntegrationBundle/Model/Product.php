<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Model;

class Product
{
    use IntegrationTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $isSimple;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $shortDescription;

    /**
     * @var array
     */
    private $productVariants;

    /**
     * @var int|null
     */
    private $taxon;

    /**
     * @var string|null
     */
    private $taxonName;

    /**
     * @var int|null
     */
    private $onHand;

    /**
     * @var int|null
     */
    private $price;

    /**
     * @var array
     */
    private $attributes;

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

    /**
     * @return array
     */
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

    /**
     * @return string|null
     */
    public function getTaxonName(): ?string
    {
        return $this->taxonName;
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
     * @param int|null $price
     * @return Product
     */
    public function setPrice(?int $price): Product
    {
        $this->price = $price;
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

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }


}