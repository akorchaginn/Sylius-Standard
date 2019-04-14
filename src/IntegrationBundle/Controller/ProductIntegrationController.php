<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:33
 */

namespace IntegrationBundle\Controller;


use Symfony\Component\HttpFoundation\Response;

class ProductIntegrationController extends IntegrationController
{

    /**
     * @return Response
     */
    public function productIndex()
    {

        $repository = $this->container->get('integration.repository');
        $repository->setSyliusEntityRepo($this->container->get('sylius.repository.product'));

        $data = $repository->getProducts();

        return parent::getResponse($data);
    }

}