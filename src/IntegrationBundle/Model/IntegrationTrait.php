<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Model;

trait IntegrationTrait
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string|null
     */
    private $id_1c;

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string|null $id_1c
     * @return $this
     */
    public function setId1c(?string $id_1c)
    {
        $this->id_1c = $id_1c;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getId1c(): ?string
    {
        return $this->id_1c;
    }


}