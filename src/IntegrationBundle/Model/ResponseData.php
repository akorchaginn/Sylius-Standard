<?php


namespace IntegrationBundle\Model;


use DateTime;

/**
 * Class ResponseData
 * @package IntegrationBundle\Model
 */
class ResponseData
{

    /**
     * @var array|null
     */
    private $data;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     * @return ResponseData
     */
    public function setData(?array $data): ResponseData
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime $dateTime
     * @return ResponseData
     */
    public function setDateTime(DateTime $dateTime): ResponseData
    {
        $this->dateTime = $dateTime;
        return $this;
    }


}