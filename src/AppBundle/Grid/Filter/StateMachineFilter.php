<?php
namespace AppBundle\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;

class StateMachineFilter implements FilterInterface
{
    public function apply(DataSourceInterface $dataSource, String $name, $data, array $options = []): void
    {
        if ($data['state'] <> '') {
            $dataSource->restrict($dataSource->getExpressionBuilder()->equals('state', $data['state']));
        }
    }
}