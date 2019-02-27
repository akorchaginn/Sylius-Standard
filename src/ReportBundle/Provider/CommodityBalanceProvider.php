<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:54
 */

namespace ReportBundle\Provider;


class CommodityBalanceProvider extends AbstractProvider
{
    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getData()
    {
            $query = $this->getQuery();
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
                    spv.on_hand as "available_on_hand",
                    spv.on_hold as "on_hold",
                    cast (scp.original_price as float8) / 100 as "original_price",
                    cast (scp.price as float8) / 100 as "unit_price",
                    cast ((spv.on_hand+spv.on_hold) * scp.original_price as float8) / 100 as "by_original_price",
                    cast ((spv.on_hand+spv.on_hold) * scp.price as float8) / 100 as "by_retail_price"
            from sylius_product_variant spv
            inner join sylius_product_translation spt on spt.id = spv.product_id
            inner join sylius_product_variant_translation spvt on spvt.id = spv.id
            inner join sylius_channel_pricing scp on scp.product_variant_id = spv.id
SQL;

        return $this->doctrineConnection->prepare($query);
    }
}