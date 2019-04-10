<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:34
 */

namespace IntegrationBundle\Controller;


class CustomerIntegrationController extends IntegrationController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function customerIndex()
    {

        $customerRepository = $this->container->get('integration.customer.repository');
        $customerRepository->setSyliusCustomerRepo($this->container->get('sylius.repository.customer'));

        $data = $customerRepository->getCustomers();

        return parent::returnResponse($data);
    }

}