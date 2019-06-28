<?php


namespace IntegrationBundle\Model;

/**
 * Class Attribute
 * @package IntegrationBundle\Model
 */
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

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

}