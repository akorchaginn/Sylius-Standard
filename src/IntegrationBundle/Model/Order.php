<?php


namespace IntegrationBundle\Model;


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
     * @var Customer
     */
    private $customer;

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
     * @param Customer $customer
     * @return Order
     */
    public function setCustomer(Customer $customer): Order
    {
        $this->customer = $customer;
        return $this;
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


}