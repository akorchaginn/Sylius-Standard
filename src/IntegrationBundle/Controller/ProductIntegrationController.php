<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:33
 */

namespace IntegrationBundle\Controller;


class ProductIntegrationController extends IntegrationController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productIndex()
    {

        $customerRepository = $this->container->get('integration.customer.repository');
        $customerRepository->setSyliusCustomerRepo($this->container->get('sylius.repository.customer'));

        $data = $customerRepository->getCustomers();

        return parent::returnResponse($data);
    }

}