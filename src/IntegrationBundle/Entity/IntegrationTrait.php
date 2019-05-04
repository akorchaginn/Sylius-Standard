<?php


namespace IntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait IntegrationTrait
{
    /**
     * @var string|null
     * @ORM\Column(name="id_1c", type="string", nullable=true)
     */
    private $id_1c;

    /**
     * @return string|null
     */
    public function getId1c(): ?string
    {
        return $this->id_1c;
    }

    /**
     * @param string|null $id_1c
     */
    public function setId1c(?string $id_1c): void
    {
        $this->id_1c = $id_1c;
    }
}