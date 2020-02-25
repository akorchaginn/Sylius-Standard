<?php


namespace IntegrationBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Component\Resource\Model\ResourceInterface as RI;

/**
 * Class Request
 * @package IntegrationBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequestRepository")
 * @ORM\Table(name="sylius_1с_request")
 */
class Request implements RI
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var DateTime
     * @ORM\Column(name="last_synchronize_input", type="datetime")
     */
    protected $lastSynchronizeInput;

    /**
     * @var DateTime
     * @ORM\Column(name="last_synchronize_output", type="datetime")
     */
    protected $lastSynchronizeOutput;

    /**
     * @var string
     * @ORM\Column(name="response_orders", type="text")
     */
    protected $responseOrders;

    /**
     * @var datetime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getLastSynchronizeInput(): DateTime
    {
        return $this->lastSynchronizeInput;
    }

    /**
     * @param DateTime $lastSynchronizeInput
     * @return Request
     */
    public function setLastSynchronizeInput(DateTime $lastSynchronizeInput): Request
    {
        $this->lastSynchronizeInput = $lastSynchronizeInput;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastSynchronizeOutput(): DateTime
    {
        return $this->lastSynchronizeOutput;
    }

    /**
     * @param DateTime $lastSynchronizeOutput
     * @return Request
     */
    public function setLastSynchronizeOutput(DateTime $lastSynchronizeOutput): Request
    {
        $this->lastSynchronizeOutput = $lastSynchronizeOutput;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseOrders(): string
    {
        return $this->responseOrders;
    }

    /**
     * @param string $responseOrders
     * @return Request
     */
    public function setResponseOrders(string $responseOrders): Request
    {
        $this->responseOrders = $responseOrders;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Request
     */
    public function setCreatedAt(DateTime $createdAt): Request
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}