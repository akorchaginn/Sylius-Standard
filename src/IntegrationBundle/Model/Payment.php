<?php


namespace IntegrationBundle\Model;

/**
 * Class Payment
 * @package IntegrationBundle\Model
 */
class Payment
{
    /**
     * @var string
     */
    private $methodLabel;

    /**
     * @var int
     */
    private $amount;

    /**
     * @param string $methodLabel
     * @return Payment
     */
    public function setMethodLabel(string $methodLabel): Payment
    {
        $this->methodLabel = $methodLabel;
        return $this;
    }

    /**
     * @param int $amount
     * @return Payment
     */
    public function setAmount(int $amount): Payment
    {
        $this->amount = $amount;
        return $this;
    }


}