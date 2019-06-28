<?php


namespace IntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait IntegrationTrait
 * @package IntegrationBundle\Entity
 */
trait IntegrationTrait
{
    /**
     * @var string|null
     * @ORM\Column(name="id_1c", type="string", nullable=true)
     */
    private $id1c;

    /**
     * @return string|null
     */
    public function getId1c(): ?string
    {
        return $this->id1c;
    }

    /**
     * @param string|null $id1c
     */
    public function setId1c(?string $id1c): void
    {
        $this->id1c = $id1c;
    }
}