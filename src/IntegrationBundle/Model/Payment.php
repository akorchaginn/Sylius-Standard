<?php


namespace IntegrationBundle\Model;


class Payment
{
    /**
     * @var string
     */
    private $methodCode;

    /**
     * @var int
     */
    private $amount;

    /**
     * @param string $methodCode
     * @return Payment
     */
    public function setMethodCode(string $methodCode): Payment
    {
        $this->methodCode = $methodCode;
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