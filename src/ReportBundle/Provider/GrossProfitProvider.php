<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 29.12.2018
 * Time: 21:19
 */

namespace ReportBundle\Provider;

use ReportBundle\Provider\AbstractProvider as AbstractProvider;

class GrossProfitProvider extends AbstractProvider
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
                select 	sp.id as "product_id",
                    base.variant_id as "variant_id",
                    spt.name as "item",
                    spvt.name as "variant",
                    base.quantity as "quantity",
                    cast(base.unit_price / 100 as float8) as "retail_price",
                    (base.quantity * cast(base.unit_price as float8)/100) as "total",
                    cast (scp.original_price as float8) / 100 as "original_price",
                    cast(base.unit_price - scp.original_price as float8) * base.quantity / 100 as "grossProfit"
                from 
                (
                    select soi.variant_id, soi.unit_price, SUM(soi.quantity) as quantity
                    from sylius_order so
                    inner join sylius_order_item soi on so.id = soi.order_id
                    where	
                        so.checkout_completed_at between ? and ?
                        and
                        so.state = 'fulfilled'
                    group by soi.variant_id, soi.unit_price
                    
                ) as base
                inner join sylius_product_variant spv on spv.id = base.variant_id
                inner join sylius_channel_pricing scp on scp.product_variant_id = base.variant_id
                inner join sylius_product sp on sp.id = spv.product_id
                inner join sylius_product_variant_translation spvt on spvt.id = base.variant_id
                inner join sylius_product_translation spt on sp.id = spt.id
                order by spt.name;

SQL;

        return $this->doctrineConnection->prepare($query);
    }
}