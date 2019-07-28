<?php


namespace IntegrationBundle\Model;

/**
 * Class Order
 * @package IntegrationBundle\Model
 */
class Order
{
    use IntegrationTrait;

    /**
     * @var string
     */
    private $number;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var int
     */
    private $customerId;

    /**
     * @var Payment
     */
    private $payment;


    /**
     * @var Shipping
     */
    private $shipping;

    /**
     * @param string $number
     * @return Order
     */
    public function setNumber(string $number): Order
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @param OrderItem $item
     * @return Order
     */
    public function addItems(OrderItem $item): Order
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Payment $payment
     * @return Order
     */
    public function setPayment(Payment $payment): Order
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @param Shipping $shipping
     * @return Order
     */
    public function setShipping(Shipping $shipping): Order
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return Order
     */
    public function setCustomerId(int $customerId): Order
    {
        $this->customerId = $customerId;
        return $this;
    }


}