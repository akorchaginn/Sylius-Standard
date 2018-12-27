<?php
/**
 * Created by PhpStorm.
 * User: akorc_000
 * Date: 25.12.2018
 * Time: 7:54
 */

namespace ReportBundle\Provider;


use Doctrine\DBAL\Connection;
use Symfony\Component\VarDumper\VarDumper;

class IncomeProvider
{

    /**
     * @var \DateTime
     */
    private $dateFrom;

    /**
     * @var \DateTime
     */
    private $dateTo;

    /**
     * @var Connection
     */
    private $doctrineConnection;

    /**
     * @param Connection $doctrineConnection
     *
     * @return IncomeProvider
     */
    public function setDoctrineConnection(Connection $doctrineConnection): IncomeProvider
    {
        $this->doctrineConnection = $doctrineConnection;
        return $this;
    }

    /**
     * @param \DateTime $dateFrom
     *
     * @return IncomeProvider
     */
    public function setDateFrom(\DateTime $dateFrom): IncomeProvider
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * @param \DateTime $dateTo
     *
     * @return IncomeProvider
     */
    public function setDateTo(\DateTime $dateTo): IncomeProvider
    {
        $this->dateTo = $dateTo;
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
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getData()
    {
            $query = $this->getQuery();
            $query->bindValue(1, $this->getDateFrom()->format('Y-m-d H:m:s'));
            $query->bindValue(2, $this->getDateTo()->format('Y-m-d H:m:s'));
            $query->execute();

            return $query->fetchAll();
    }

    /**
     * @return \Doctrine\DBAL\Statement
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getQuery()
    {
        $query = <<<SQL
            select  spt.name as "product",
                    spvt.name as "variant",
                    soi.quantity as "quantity",
                    cast (soi.unit_price as float8) / 100 as "price",
                    cast (soi.quantity * soi.unit_price as float8) / 100 as "total",
                    so.checkout_completed_at as "order_date"
            from sylius_order so
            inner join sylius_order_item soi on soi.order_id = so.id
            inner join sylius_product_variant_translation spvt on spvt.id = soi.variant_id
            inner join sylius_product_variant spv on spv.id = soi.variant_id
            inner join sylius_product_translation spt on spt.id = spv.product_id
            where so.created_at between ? and ?
              and
                so.state = 'fulfilled';
SQL;

        return $this->doctrineConnection->prepare($query);
    }
}