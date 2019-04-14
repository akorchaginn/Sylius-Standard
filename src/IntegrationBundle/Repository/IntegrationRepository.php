<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Repository;

use IntegrationBundle\Model\Customer;
use IntegrationBundle\Model\Product;
use IntegrationBundle\Model\ProductVariant;
use Sylius\Component\Resource\Repository\RepositoryInterface as BaseRepository;
use IntegrationBundle\Model\Factory;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Product\Model\ProductInterface;

/**
 * Class IntegrationRepository
 * @package IntegrationBundle\Repository
 */
class IntegrationRepository
{
    /**
     * @var BaseRepository
     */
    private $syliusEntityRepository;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * IntegrationRepository constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }


    public function setSyliusEntityRepo($repository)
    {
        $this->syliusEntityRepository = $repository;
    }

    /**
     * @return array|null
     */
    public function getCustomers()
    {
        $integrationCustomers = [];

        $syliusCustomers = $this->syliusEntityRepository->findAll();

        /**
         * @var CustomerInterface $customer
         */
        foreach ($syliusCustomers as $customer)
        {
            /**
             * @var Customer
             */
            $integrationCustomer = $this->factory->createCustomer();

            $integrationCustomer->setId($customer->getId())
                ->setFirstName($customer->getFirstName())
                ->setLastName($customer->getLastName())
                ->setGender($customer->getGender())
                ->setBirthday($customer->getBirthday())
                ->setEmail($customer->getEmail())
                ->setPhoneNumber($customer->getPhoneNumber());

            $integrationCustomers[] = $integrationCustomer;
        }

        return $integrationCustomers;
    }

    /**
     * @return array|null
     */
    public function getProducts()
    {
        $integrationProducts = [];

        $syliusProducts = $this->syliusEntityRepository->findAll();

        /**
         * @var ProductInterface $product
         */
        foreach ($syliusProducts as $product)
        {
            /**
             * @var Product
             */
            $integrationProduct = $this->factory->createProduct();

            $integrationProduct->setId($product->getId())
                ->setName($product->getName())
                ->setDescription($product->getDescription())
                ->setShortDescription($product->getShortDescription())
                //->setId1c($product->getId1c())
                ->isSimple($product->isSimple());

            $integrationProduct->setTaxon(is_object($product->getMainTaxon()) ? $product->getMainTaxon()->getId() : null);

            if ($product->isSimple())
            {
                $integrationProduct->setPrice($product->getVariants()->first()->getChannelPricings()->first()->getPrice())
                    ->setOnHand($product->getVariants()->first()->getOnHand());
            } else{

                foreach ($product->getVariants() as $variant)
                {
                    /**
                     * @var ProductVariant
                     */
                    $integrationProductVariant = $this->factory->createProductVariant();

                    $integrationProductVariant->setId($variant->getId())
                        ->setPrice($variant->getChannelPricings()->first()->getPrice())
                        ->setOnHand($variant->getOnHand())
                        ->setName($variant->getName());
                    //->setId1c($variant->getId1C);

                    $integrationProduct->addProductVariant($integrationProductVariant);
                }
            }

            $integrationProducts[] = $integrationProduct;

        }

        return $integrationProducts;
    }
}