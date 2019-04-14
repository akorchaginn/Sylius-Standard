<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:34
 */

namespace IntegrationBundle\Controller;


use Symfony\Component\HttpFoundation\Response;

class CustomerIntegrationController extends IntegrationController
{

    /**
     * @return Response
     */
    public function customerIndex()
    {

        $customerRepository = $this->container->get('integration.repository');
        $customerRepository->setSyliusEntityRepo($this->container->get('sylius.repository.customer'));

        $data = $customerRepository->getCustomers();

        return parent::getResponse($data);
    }

}