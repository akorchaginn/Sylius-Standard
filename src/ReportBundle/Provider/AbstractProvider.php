<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 29.12.2018
 * Time: 9:58
 */

namespace ReportBundle\Provider;

use Doctrine\DBAL\Connection;
use Symfony\Component\VarDumper\VarDumper;

class AbstractProvider
{

    /**
     * @var Connection
     */
    protected $doctrineConnection;

    /**
     * @var \DateTime
     */
    protected $dateFrom;

    /**
     * @var \DateTime
     */
    protected $dateTo;

    /**
     * @param \DateTime $dateTo
     *
     * @return AbstractProvider
     */
    public function setDateTo(\DateTime $dateTo): AbstractProvider
    {
        $this->dateTo = $dateTo->setTime(23,59,59);
        return $this;
    }

    /**
     * @param \DateTime $dateFrom
     *
     * @return AbstractProvider
     */
    public function setDateFrom(\DateTime $dateFrom): AbstractProvider
    {
        $this->dateFrom = $dateFrom->setTime(0,0,0);
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param Connection $doctrineConnection
     *
     * @return AbstractProvider
     */
    public function setDoctrineConnection(Connection $doctrineConnection): AbstractProvider
    {
        $this->doctrineConnection = $doctrineConnection;
        return $this;
    }
}