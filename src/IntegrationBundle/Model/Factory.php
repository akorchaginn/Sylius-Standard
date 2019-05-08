<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 15:22
 */

namespace IntegrationBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException as ORMException;
use Sylius\Component\Attribute\Factory\AttributeFactory;
use Sylius\Component\Attribute\Model\AttributeInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Locale\Model\Locale;
use Sylius\Component\Product\Factory\ProductFactory;
use Sylius\Component\Product\Factory\ProductVariantFactory;
use Sylius\Component\Product\Generator\SlugGenerator;
use IntegrationBundle\Entity\ProductInterface as ProductInterface;
use IntegrationBundle\Entity\ProductVariantInterface as ProductVariantInterface;
use Sylius\Component\Product\Model\ProductAttribute;
use Sylius\Component\Resource\Factory\Factory as EntityFactory;

/**
 * Class Factory
 * @package IntegrationBundle\Model
 */
class Factory
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProductFactory $productFactory
     */
    private $productFactory;

    /**
     * @var ProductVariantFactory $productVariantFactory
     */
    private $productVariantFactory;

    /**
     * @var AttributeFactory $attributeFactory
     */
    private $attributeFactory;

    /**
     * @var SlugGenerator $slugGenerator
     */
    private $slugGenerator;

    /**
     * @var EntityFactory
     */
    private $attributeValueFactory;

    /**
     * @var EntityFactory
     */
    private $channelPricingFactory;

    /**
     * @var ChannelInterface
     */
    private $defaultChannel;

    /**
     * @var ProductTaxonInterface
     */
    private $defaultTaxon;

    /**
     * Factory constructor.
     * @param EntityManager $em
     * @param ProductFactory $productFactory
     * @param ProductVariantFactory $productVariantFactory
     * @param AttributeFactory $attributeFactory
     * @param SlugGenerator $slugGenerator
     * @param EntityFactory $attributeValueFactory
     * @param EntityFactory $channelPricingFactory
     */
    public function __construct(EntityManager $em,
                                ProductFactory $productFactory,
                                ProductVariantFactory $productVariantFactory,
                                AttributeFactory $attributeFactory,
                                SlugGenerator $slugGenerator,
                                EntityFactory $attributeValueFactory,
                                EntityFactory $channelPricingFactory)
    {
        $this->entityManager = $em;
        $this->productFactory = $productFactory;
        $this->productVariantFactory = $productVariantFactory;
        $this->attributeFactory = $attributeFactory;
        $this->slugGenerator = $slugGenerator;
        $this->attributeValueFactory = $attributeValueFactory;
        $this->channelPricingFactory = $channelPricingFactory;
    }

    public function setDefaults(ChannelInterface $defaultChannel, ProductTaxonInterface $defaultTaxon)
    {
        $this->defaultChannel = $defaultChannel;
        $this->defaultTaxon = $defaultTaxon;
    }

    /**
     * @return Customer
     */
    public function createCustomer()
    {
        $customer = new Customer();

        return $customer;
    }

    /**
     * @return ProductVariant
     */
    public function createProductVariant()
    {
        $productVariant = new ProductVariant();

        return $productVariant;
    }

    /**
     * @return Product
     */
    public function createProduct()
    {
        $product = new Product();

        return $product;
    }

    /**
     * @return Order
     */
    public function createOrder()
    {
        $order = new Order();

        return $order;
    }

    /**
     * @return Shipping
     */
    public function createShipping()
    {
        $shipping = new Shipping();

        return $shipping;
    }

    /**
     * @return OrderItem
     */
    public function createOrderItem()
    {
        $orderItem = new OrderItem();

        return $orderItem;
    }

    /**
     * @return Payment
     */
    public function createPayment()
    {
        $payment = new Payment();

        return $payment;
    }

    /**
     * @return Attribute
     */
    public function createAttribute()
    {
        $attribute = new Attribute();

        return $attribute;
    }

    /**
     * @param Product $product
     * @return ProductInterface|\Sylius\Component\Product\Model\ProductInterface
     * @throws ORMException
     */
    public function createSyliusProduct(Product $product)
    {
        /**
         * @todo Чёт сомнительно. Надо перепроверить
         */
        if (empty($product->getProductVariants()))
        {
            /**
             * @var ProductInterface $syliusProduct
             */
            $syliusProduct = $this->productFactory->createWithVariant();
            $syliusProduct->getVariants()->first()->setOnHand($product->getOnHand());
            $syliusProduct->getVariants()->first()->setPrice($product->getPriceRegular());
            $syliusProduct->getVariants()->first()->setName($product->getName());
            $syliusProduct->getVariants()->first()->setEnabled(true);
        }else {
            $syliusProduct = $this->productFactory->createNew();

            foreach ($product->getProductVariants() as $variant)
            {
                $syliusProductVariant = $this->createSyliusVariant($variant);
                $syliusProduct->addVariant($syliusProductVariant);
            }
        }

        foreach ($product->getAttributes() as $attribute)
        {
            $syliusProductAttribute = $this->createProductAttribute($attribute);
            $syliusProduct->addAttribute($syliusProductAttribute);

        }


        $syliusProduct->setName($product->getName());
        $syliusProduct->setCode($this->slugGenerator->generate($product->getName()));
        $syliusProduct->setSlug($this->slugGenerator->generate($product->getName()));
        $syliusProduct->setId1C($product->getId1c());
        $syliusProduct->setDescription($product->getDescription());
        $syliusProduct->addProductTaxon($this->defaultTaxon);
        $syliusProduct->addChannel($this->defaultChannel);

        return $syliusProduct;
    }

    /**
     * @param ProductVariant $productVariant
     * @return ProductVariantInterface
     */
    public function createSyliusVariant(ProductVariant $productVariant)
    {

        /**
         * @var ChannelPricingInterface $syliusChannelPricing
         */
        $syliusChannelPricing = $this->channelPricingFactory->createNew();
        $syliusChannelPricing->setPrice($productVariant->getPriceRegular());
        $syliusChannelPricing->setChannelCode($this->defaultChannel->getCode());

        /**
         * @var ProductVariantInterface $syliusProductVariant
         */
        $syliusProductVariant = $this->productVariantFactory->createNew();
        $syliusProductVariant->setName($productVariant->getName());
        $syliusProductVariant->setCode($this->slugGenerator->generate($productVariant->getName()));
        $syliusProductVariant->setEnabled($productVariant->getEnabled());
        $syliusProductVariant->setId1C($productVariant->getId1c());
        $syliusProductVariant->setOnHand($productVariant->getOnHand());
        $syliusProductVariant->addChannelPricing($syliusChannelPricing);
        $syliusProductVariant->setTracked(true);

        return $syliusProductVariant;
    }

    /**
     * @param Attribute $attribute
     * @return AttributeValueInterface
     * @throws ORMException
     */
    public function createProductAttribute(Attribute $attribute)
    {

        $syliusAttribute = $this->createSyliusAttribute($attribute->getName());
        /**
         * @var AttributeValueInterface $syliusAttributeValue
         */
        $syliusAttributeValue = $this->attributeValueFactory->createNew();

        $syliusAttributeValue->setAttribute($syliusAttribute);
        $syliusAttributeValue->setValue($attribute->getValue());
        $syliusAttributeValue->setLocaleCode($this->entityManager->getRepository(Locale::class)->findAll()[0]->getCode());

        return $syliusAttributeValue;
    }

    /**
     * @param string $attributeName
     * @return AttributeInterface|ProductAttribute
     * @throws ORMException
     */
    private function createSyliusAttribute(string $attributeName)
    {
        $syliusAttribute = $this->entityManager->getRepository(ProductAttribute::class)->findOneBy(['code' => $this->slugGenerator->generate($attributeName)]);
        if (!is_object($syliusAttribute))
        {
            $syliusAttribute = $this->attributeFactory->createTyped('text');
            $syliusAttribute->setName($attributeName);
            $syliusAttribute->setCode($this->slugGenerator->generate($attributeName));

            $this->entityManager->persist($syliusAttribute);
        }

        return $syliusAttribute;
    }
}
