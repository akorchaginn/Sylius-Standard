<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:33
 */

namespace IntegrationBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

        $response['data'] = $data;
        return parent::getResponse($response);
    }

    /**
     * @param array $products
     * @ParamConverter("products", class="array<IntegrationBundle\Model\Product>", converter="fos_rest.request_body")
     * @return Response
     *
     */
    public function productCreateOrUpdate(array $products)
    {
        return parent::getResponse($products);
    }
}