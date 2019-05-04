<?php


namespace IntegrationBundle\Model;


class Attribute
{

    /**
     * @var string|null
     */
    private $value;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @param string|null $value
     * @return Attribute
     */
    public function setValue(?string $value): Attribute
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string|null $name
     * @return Attribute
     */
    public function setName(?string $name): Attribute
    {
        $this->name = $name;
        return $this;
    }
}