<?php

declare(strict_types=1);

namespace Override\AddressingBundle\Entity;

use Sylius\Component\Core\Model\Address as BaseAddress;
use Sylius\Component\Core\Model\AddressInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 * @package Override\AddressingBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sylius_address")
 */
class Address extends BaseAddress implements AddressInterface
{
    /** @var string|null
     * @ORM\Column(name="fias_code", type="string", nullable=true)
     */
    protected $fiasCode;

    /**
     * @return string|null
     */
    public function getFiasCode(): ?string
    {
        return $this->fiasCode;
    }

    /**
     * @param string|null $fiasCode
     * @return Address
     */
    public function setFiasCode(?string $fiasCode): Address
    {
        $this->fiasCode = $fiasCode;
        return $this;
    }
}
