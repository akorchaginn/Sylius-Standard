<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:54
 */

namespace ReportBundle\Provider;


class IncomeProvider extends AbstractProvider
{
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
            select  spt.name as "item",
                    spvt.name as "variant",
                    soi.quantity as "quantity",
                    cast (soi.unit_price as float8) / 100 as "unit_price",
                    cast (soi.quantity * soi.unit_price as float8) / 100 as "total",
                    so.checkout_completed_at as "creation_time"
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