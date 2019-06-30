<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 15:22
 */

namespace IntegrationBundle\Model;

use DateTime;
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
use IntegrationBundle\Entity\Product as SyliusProduct;
use IntegrationBundle\Entity\ProductInterface as ProductInterface;
use IntegrationBundle\Entity\ProductVariant as SyliusProductVariant;
use IntegrationBundle\Entity\ProductVariantInterface as ProductVariantInterface;
use Sylius\Component\Product\Model\ProductAttribute;
use Sylius\Component\Product\Model\ProductAttributeValue;
use Sylius\Component\Resource\Factory\Factory as EntityFactory;
use Urbanara\CatalogPromotionPlugin\Action\FixedCatalogDiscountCommand;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotion;
use Urbanara\CatalogPromotionPlugin\Entity\CatalogRule;
use Urbanara\CatalogPromotionPlugin\Rule\IsProductRuleChecker;

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
     * @var EntityFactory
     */
    private $catalogPromotionFactory;

    /**
     * @var EntityFactory
     */
    private $catalogRuleFactory;

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
     * @param EntityFactory $catalogPromotionFactory
     * @param EntityFactory $catalogRuleFactory
     */
    public function __construct(EntityManager $em,
                                ProductFactory $productFactory,
                                ProductVariantFactory $productVariantFactory,
                                AttributeFactory $attributeFactory,
                                SlugGenerator $slugGenerator,
                                EntityFactory $attributeValueFactory,
                                EntityFactory $channelPricingFactory,
                                EntityFactory $catalogPromotionFactory,
                                EntityFactory $catalogRuleFactory)
    {
        $this->entityManager = $em;
        $this->productFactory = $productFactory;
        $this->productVariantFactory = $productVariantFactory;
        $this->attributeFactory = $attributeFactory;
        $this->slugGenerator = $slugGenerator;
        $this->attributeValueFactory = $attributeValueFactory;
        $this->channelPricingFactory = $channelPricingFactory;
        $this->catalogPromotionFactory = $catalogPromotionFactory;
        $this->catalogRuleFactory = $catalogRuleFactory;
    }

    /**
     * @param ChannelInterface $defaultChannel
     * @param ProductTaxonInterface $defaultTaxon
     */
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
         * Подготовка объекта Product
         */
        $syliusProduct = $this->entityManager->getRepository(SyliusProduct::class)->findOneBy(["id" => $product->getId()]);
        if (!is_object($syliusProduct) && !empty($product->getId1c())) {
            $syliusProduct = $this->entityManager->getRepository(SyliusProduct::class)->findOneBy(["id1c" => $product->getId1c()]);
        }
        if (!is_object($syliusProduct)) {
            if (empty($product->getProductVariants())) {
                /**
                 * @var ProductInterface $syliusProduct
                 */
                $syliusProduct = $this->productFactory->createWithVariant();

                /**
                 * @var ChannelPricingInterface $syliusChannelPricing
                 */
                $syliusChannelPricing = $this->channelPricingFactory->createNew();
                $syliusChannelPricing->setChannelCode($this->defaultChannel->getCode());

                $syliusProduct->getVariants()->first()->addChannelPricing($syliusChannelPricing);
                $syliusProduct->getVariants()->first()->setCode($this->slugGenerator->generate($product->getName() . '_simpleVariant'));
                $syliusProduct->getVariants()->first()->setTracked(true);
                $syliusProduct->getVariants()->first()->setEnabled(false);

            } else {
                $syliusProduct = $this->productFactory->createNew();
            }
            $syliusProduct->setCode($this->slugGenerator->generate($product->getName() . '_' . $product->getId1c()));
            $syliusProduct->setSlug($this->slugGenerator->generate($product->getName() . '_' . $product->getId1c()));
            $syliusProduct->addProductTaxon($this->defaultTaxon);
            $syliusProduct->addChannel($this->defaultChannel);

        }

        if (empty($product->getProductVariants())) {
            $variant = $syliusProduct->getVariants()->first();

            $variant->setOnHand($product->getOnHand());
            $variant->getChannelPricingForChannel($this->defaultChannel)->setPrice($product->getPriceRegular());
            $variant->setName($product->getName());
        }

        $syliusProduct->setName($product->getName());

        $syliusProduct->setId1C($product->getId1c());
        $syliusProduct->setDescription($product->getDescription());

        foreach ($product->getProductVariants() as $variant) {
            $syliusProductVariant = $this->createSyliusVariant($variant, $syliusProduct);
            $syliusProduct->addVariant($syliusProductVariant);
        }

        $cloneSyliusProductAttributes = clone $syliusProduct->getAttributes();

        foreach ($product->getAttributes() as $attribute)
        {
            $syliusProductAttribute = $this->createProductAttribute($attribute, $syliusProduct);
            $syliusProduct->addAttribute($syliusProductAttribute);
            $cloneSyliusProductAttributes->removeElement($syliusProductAttribute);
        }

        foreach ($cloneSyliusProductAttributes as $attribute)
        {
            $syliusProduct->getAttributes()->removeElement($attribute);
        }

        $this->applyCatalogPromotion($product, $syliusProduct);

        return $syliusProduct;
    }

    /**
     * @param ProductVariant $productVariant
     * @param SyliusProduct $syliusProduct
     * @return SyliusProductVariant|ProductVariantInterface|object|null
     */
    public function createSyliusVariant(ProductVariant $productVariant, SyliusProduct $syliusProduct)
    {
        /**
         * Подготовка объекта ProductVariant
         */
        $syliusProductVariant = $this->entityManager->getRepository(SyliusProductVariant::class)->findOneBy(["id" => $productVariant->getId()]);
        if (!is_object($syliusProductVariant) && !empty($productVariant->getId1c())) {
            $syliusProductVariant = $this->entityManager->getRepository(SyliusProductVariant::class)->findOneBy(["id1c" => $productVariant->getId1c()]);
        }
        if (!is_object($syliusProductVariant)) {
            /**
             * @var ChannelPricingInterface $syliusChannelPricing
             */
            $syliusChannelPricing = $this->channelPricingFactory->createNew();
            $syliusChannelPricing->setChannelCode($this->defaultChannel->getCode());

            /**
             * @var ProductVariantInterface $syliusProductVariant
             */
            $syliusProductVariant = $this->productVariantFactory->createNew();
            $syliusProductVariant->addChannelPricing($syliusChannelPricing);
            $syliusProductVariant->setCode($syliusProduct->getCode() . '_' . $this->slugGenerator->generate($productVariant->getName()));
        }

        $syliusProductVariant->getChannelPricingForChannel($this->defaultChannel)->setPrice($productVariant->getPriceRegular());
        $syliusProductVariant->setName($productVariant->getName());
        $syliusProductVariant->setId1c($productVariant->getId1c());
        $syliusProductVariant->setOnHand($productVariant->getOnHand());

        $syliusProductVariant->setTracked(true);
        $syliusProductVariant->setEnabled(true);

        return $syliusProductVariant;
    }

    /**
     * @param Attribute $attribute
     * @param SyliusProduct $syliusProduct
     * @return object|AttributeValueInterface|ProductAttributeValue|null
     * @throws ORMException
     */
    public function createProductAttribute(Attribute $attribute, SyliusProduct $syliusProduct)
    {
        $syliusAttribute = $this->createSyliusAttribute($attribute->getName());

        if ($syliusProduct->getId() && $syliusAttribute->getId())
        {
            $syliusAttributeValue = $this->entityManager->getRepository(ProductAttributeValue::class)->findOneBy(['attribute' => $syliusAttribute, 'subject' => $syliusProduct]);
        }
        if (empty($syliusAttributeValue))
        {
            /**
             * @var AttributeValueInterface $syliusAttributeValue
             */
            $syliusAttributeValue = $this->attributeValueFactory->createNew();
            $syliusAttributeValue->setAttribute($syliusAttribute);
            $syliusAttributeValue->setLocaleCode($this->entityManager->getRepository(Locale::class)->findAll()[0]->getCode());
        }
        $syliusAttributeValue->setValue($attribute->getValue());

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
        if (empty($syliusAttribute))
        {
            $syliusAttribute = $this->attributeFactory->createTyped('text');
            $syliusAttribute->setName($attributeName);
            $syliusAttribute->setCode($this->slugGenerator->generate($attributeName));

            $this->entityManager->persist($syliusAttribute);
            $this->entityManager->flush();
        }
        return $syliusAttribute;
    }

    /**
     * @param Product $product
     * @param SyliusProduct $syliusProduct
     * @throws ORMException
     */
    private function applyCatalogPromotion(Product $product, SyliusProduct $syliusProduct)
    {
        if (!empty($product->getProductVariants()))
        {
            /**
             * @var ProductVariant $productVariant
             */
            $productVariant = $product->getProductVariants()[0];
            $difference = $productVariant->getPriceRegular() - $productVariant->getPricePromotion();
        }else {
            $difference = $product->getPriceRegular() - $product->getPricePromotion();
        }

        $catalogPromotion = $this->entityManager->getRepository(CatalogPromotion::class)->findOneBy(['code' => $syliusProduct->getCode()]);
        if (empty($catalogPromotion) && $difference > 0 )
        {
            /**
             * @var CatalogPromotion $catalogPromotion
             */
            $catalogPromotion = $this->catalogPromotionFactory->createNew();

            /**
             * @var CatalogRule $catalogRule
             */
            $catalogRule = $this->catalogRuleFactory->createNew();
            $catalogRule->setType(IsProductRuleChecker::TYPE);

            $catalogPromotion->setCode($syliusProduct->getCode());
            $catalogPromotion->setName($syliusProduct->getTranslation()->getName());
            $catalogPromotion->setDiscountType(FixedCatalogDiscountCommand::TYPE);
            $catalogPromotion->addChannel($this->defaultChannel);
            $catalogPromotion->addRule($catalogRule);
        }

        if (is_object($catalogPromotion) && $difference > 0 )
        {
            $catalogRule = $catalogPromotion->getRules()->first();

            $activeDate = new DateTime();
            $discountConfiguration = ['values' =>
                ['default' => $difference]
            ];

            $ruleConfiguration = [
                'products' =>
                    [$syliusProduct->getCode()]
            ];

            $catalogPromotion->setDiscountConfiguration($discountConfiguration);
            $catalogPromotion->setStartsAt(clone $activeDate);
            $catalogPromotion->setEndsAt($activeDate->modify('+1 year'));

            $catalogRule->setConfiguration($ruleConfiguration);
        }

        if (is_object($catalogPromotion) && $difference <= 0 )
        {
            $activeDate = new DateTime();

            $catalogPromotion->setStartsAt($activeDate->modify('-2 days'));
            $catalogPromotion->setEndsAt($activeDate);
        }

        if (is_object($catalogPromotion))
        {
            $this->entityManager->persist($catalogPromotion);
        }

        if (!empty($catalogRule))
        {
            $this->entityManager->persist($catalogRule);
        }
    }
}