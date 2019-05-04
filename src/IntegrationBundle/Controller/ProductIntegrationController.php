<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:33
 */

namespace IntegrationBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function productCreateOrUpdate(array $products)
    {
        VarDumper::dump($products);
        die();
    }
}