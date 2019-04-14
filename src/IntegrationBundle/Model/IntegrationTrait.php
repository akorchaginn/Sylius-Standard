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
     * @var integer|null
     */
    private $id_1c;

    /**
     * @param mixed $id
     * @return IntegrationTrait
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int|null $id_1c
     * @return IntegrationTrait
     */
    public function setId1c(?int $id_1c): IntegrationTrait
    {
        $this->id_1c = $id_1c;
        return $this;
    }


}