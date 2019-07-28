<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Repository;

use AppBundle\Entity\OrderItemInterface;
use DateTime;
use IntegrationBundle\Entity\ProductInterface;
use IntegrationBundle\Entity\OrderInterface;
use IntegrationBundle\Entity\CustomerInterface;
use IntegrationBundle\Entity\ProductVariantInterface;
use Sylius\Component\Attribute\Model\AttributeInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Payment\Model\Payment;
use Sylius\Component\Resource\Repository\RepositoryInterface as BaseRepository;
use IntegrationBundle\Model\Factory;
use Sylius\Component\Core\Model\AdjustmentInterface;

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

    /**
     * @param BaseRepository $repository
     */
    public function setSyliusEntityRepo(BaseRepository $repository): void
    {
        $this->syliusEntityRepository = $repository;
    }

    /**
     * @param int|null $id
     * @return array
     */
    public function getCustomers(int $id = null): array
    {
        $integrationCustomers = [];

        $syliusCustomers = !is_null($id) ? $this->syliusEntityRepository->findBy(['id' => $id ]) : $this->getActiveCustomers();

        $syliusCustomers = $this->processCustomers($syliusCustomers);

        /**
         * @var CustomerInterface $customer
         */
        foreach ($syliusCustomers as $customer)
        {
            $integrationCustomer = $this->factory->createCustomer();

            $integrationCustomer->setId($customer->getId())
                ->setId1c($customer->getId1c())
                ->setFirstName($customer->getFirstName())
                ->setLastName($customer->getLastName())
                ->setGender($customer->getGender())
                ->setBirthday($customer->getBirthday())
                ->setEmail($customer->getEmail())
                ->setSubscribedToNews($customer->isSubscribedToNewsletter())
                ->setPhoneNumber($customer->getPhoneNumber());
            $integrationCustomers[] = $integrationCustomer;
        }

        return $integrationCustomers;
    }

    /**
     * @return array|null
     */
    public function getProducts(): ?array
    {
        $integrationProducts = [];

        $syliusProducts = $this->syliusEntityRepository->findAll();

        /**
         * @var ProductInterface $product
         */
        foreach ($syliusProducts as $product)
        {
            $integrationProduct = $this->factory->createProduct();

            $integrationProduct->setId($product->getId())
                ->setName($product->getName())
                ->setShortDescription(strip_tags ($product->getShortDescription()))
                ->setId1c($product->getId1c())
                ->isSimple($product->isSimple());

            $integrationProduct->setTaxon(is_object($product->getMainTaxon()) ? $product->getMainTaxon()->getId() : null);
            $integrationProduct->setTaxonName(is_object($product->getMainTaxon()) ? $product->getMainTaxon()->getName() : null);

            if ($product->isSimple())
            {
                $integrationProduct->setPriceRegular($product->getVariants()->first()->getChannelPricings()->first()->getPrice())
                    ->setPricePromotion($product->getVariants()->first()->getChannelPricings()->first()->getPrice())
                    ->setOnHand($product->getVariants()->first()->getOnHand())
                    ->setOriginalPrice($product->getVariants()->first()->getChannelPricings()->first()->getOriginalPrice());
            } else{

                /**
                 * @var ProductVariantInterface $variant
                 */
                foreach ($product->getVariants() as $variant)
                {
                    $integrationProductVariant = $this->factory->createProductVariant();

                    $integrationProductVariant->setId($variant->getId())
                        ->setPriceRegular($variant->getChannelPricings()->first()->getPrice())
                        ->setPricePromotion($variant->getChannelPricings()->first()->getPrice())
                        ->setOriginalPrice($variant->getChannelPricings()->first()->getOriginalPrice())
                        ->setOnHand($variant->getOnHand())
                        ->setName($variant->getName())
                        ->setId1c($variant->getId1c());

                    $integrationProduct->addProductVariant($integrationProductVariant);
                }
            }

            /**
             * @var AttributeInterface $syliusAttribute
             */
            foreach ($syliusAttributes = $product->getAttributes() as $syliusAttribute)
            {
                $integrationAttribute = $this->factory->createAttribute();
                $integrationAttribute->setName($syliusAttribute->getName())
                    ->setValue($syliusAttribute->getValue());
                $integrationProduct->addAttribute($integrationAttribute);
            }

            $integrationProducts[] = $integrationProduct;

        }

        return $integrationProducts;
    }

    /**
     * @param DateTime $lastSynchronized
     * @return array
     */
    public function getOrders(DateTime $lastSynchronized): array
    {
        $integrationOrders = [];
        $syliusOrdersAll = $this->syliusEntityRepository->findAll();
        $syliusOrders = array_filter($syliusOrdersAll, (function (OrderInterface $order) use ($lastSynchronized) {
            if (!is_null($order->getNumber()) and $order->getCheckoutCompletedAt() > $lastSynchronized)
            {
                return true;
            }
            return false;
        }));

        /**
         * @var OrderInterface $syliusOrder
         */
        foreach ($syliusOrders as $syliusOrder)
        {
            $integrationOrder = $this->factory->createOrder();

            $integrationOrder->setId($syliusOrder->getId())
                ->setNumber($syliusOrder->getNumber())
                ->setCustomerId($syliusOrder->getCustomer()->getId())
                ->setId1c($syliusOrder->getId1c());

            /**
             * @var Payment $syliusPayment
             */
            foreach ($syliusPayments = $syliusOrder->getPayments() as $syliusPayment)
            {
                $payment = $this->factory->createPayment();
                $payment->setAmount($syliusPayment->getAmount())
                    ->setMethodCode($syliusPayment->getMethod()->getCode());

                $integrationOrder->setPayment($payment);
            }

            /**
             * @var OrderItemInterface $syliusOrderItem
             */
            foreach ($syliusOrderItems = $syliusOrder->getItems() as $syliusOrderItem)
            {
                $item = $this->factory->createOrderItem();
                $item->setProductId($syliusOrderItem->getVariant()->getProduct()->getId())
                     ->setProductId1c($syliusOrderItem->getVariant()->getProduct()->getId1c())
                     ->setQuantity($syliusOrderItem->getQuantity())
                     ->setPrice($syliusOrderItem->getUnitPrice());

                if (!$syliusOrderItem->getProduct()->isSimple())
                {
                    $item->setVariantId($syliusOrderItem->getVariant()->getId())
                        ->setVariantId1c($syliusOrderItem->getVariant()->getId1c());
                }

                $integrationOrder->addItems($item);
            }

            if ($shippingAdjustments = $syliusOrder->getAdjustments(AdjustmentInterface::SHIPPING_ADJUSTMENT)) {

                /**
                 * @var AddressInterface $shippingAddress
                 */
                $shippingAddress = $syliusOrder->getShippingAddress();
                /**
                 * @var AdjustmentInterface $syliusShipping
                 */
                $syliusShipping = $shippingAdjustments->first();
                $address =  $shippingAddress->getPostcode() . ', '.
                            $shippingAddress->getCountryCode() . ', '.
                            $shippingAddress->getCity() . ', '.
                            $shippingAddress->getProvinceName() . ', '.
                            $shippingAddress->getStreet();

                $receiver = $shippingAddress->getFirstName() . ' '.
                            $shippingAddress->getLastName() . ', '.
                            $shippingAddress->getPhoneNumber();

                $shipping = $this->factory->createShipping();
                $shipping->setType(AdjustmentInterface::SHIPPING_ADJUSTMENT)
                    ->setLabel($syliusShipping->getLabel())
                    ->setAmount($syliusShipping->getAmount())
                    ->setAddress($address)
                    ->setReceiver($receiver);

                $integrationOrder->setShipping($shipping);

            }

            $integrationOrders[] = $integrationOrder;
        }

        return $integrationOrders;
    }

    /**
     * @return array|null
     */
    private function getActiveCustomers(): ?array
    {
        $customers = array_filter($this->syliusEntityRepository->findBy([]), (function (CustomerInterface $customer) {
            if (!is_null($customer->getUser()) && $customer->getUser()->isVerified())
            {
                return true;
            }
            return false;
        }));
        return $customers;
    }

    /**
     * @param array $syliusCustomers
     * @return array
     */
    private function processCustomers(array $syliusCustomers): array
    {
        $customers = array_map(function(CustomerInterface $customer) {
            if ((empty($customer->getFirstName()) or empty($customer->getPhoneNumber()))) {
                $conditions = (count($customer->getOrders()) > 0 && count($customer->getOrders()->first()->getShippingAddress()) > 0);
            } else {
                $conditions = false;
            }

            if (empty($customer->getFirstName()) && $conditions)
            {
                /**
                 * @var AddressInterface $address
                 */
                $address = $customer->getOrders()->first()->getShippingAddress();
                $customer->setFirstName($address->getFirstName());
                $customer->setLastName($address->getLastName());
            }
            if (empty($customer->getPhoneNumber()) && $conditions)
            {
                $address = $customer->getOrders()->first()->getShippingAddress();
                $customer->setPhoneNumber($address->getPhoneNumber());
            }

            return $customer;
        }, $syliusCustomers);
        return $customers;
    }
}