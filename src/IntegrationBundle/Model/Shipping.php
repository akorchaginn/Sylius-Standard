<?php


namespace IntegrationBundle\Model;

/**
 * Class Shipping
 * @package IntegrationBundle\Model
 */
class Shipping
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $address;

    /**
     * @param string $type
     * @return Shipping
     */
    public function setType(string $type): Shipping
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $label
     * @return Shipping
     */
    public function setLabel(string $label): Shipping
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param int $amount
     * @return Shipping
     */
    public function setAmount(int $amount): Shipping
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $address
     * @return Shipping
     */
    public function setAddress(string $address): Shipping
    {
        $this->address = $address;
        return $this;
    }
}