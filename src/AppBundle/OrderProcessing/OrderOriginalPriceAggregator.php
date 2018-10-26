<?php
/**
 * Created by PhpStorm.
 * User: akorc_000
 * Date: 16.10.2018
 * Time: 20:47
 */

namespace AppBundle\OrderProcessing;

use AppBundle\Entity\OrderItemInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Webmozart\Assert\Assert;

class OrderOriginalPriceAggregator implements OrderProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(OrderInterface $order): void
    {
        /** @var OrderInterface $order */
        Assert::isInstanceOf($order, OrderInterface::class);
        $channel = $order->getChannel();

        /**
         * @var OrderItemInterface $item
         */
        foreach ($order->getItems() as $item) {
            if ($item->isImmutable()) {
                continue;
            }

            $variant = $item->getVariant();
            $channelPricing = $variant->getChannelPricingForChannel($channel);
            $price = $channelPricing->getOriginalPrice() ? $channelPricing->getOriginalPrice() : 0;
            $item->setOriginalPrice($price);
        }
    }

}