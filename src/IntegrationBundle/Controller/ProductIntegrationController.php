<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:33
 */

namespace IntegrationBundle\Controller;

use DateTime;
use Doctrine\ORM\ORMException;
use Exception;
use IntegrationBundle\Entity\Product as SyliusProduct;
use IntegrationBundle\Entity\ProductInterface;
use IntegrationBundle\Model\Factory;
use IntegrationBundle\Model\Product;
use IntegrationBundle\Model\ResponseData;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ProductTaxon;
use Sylius\Component\Core\Model\Taxon;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductIntegrationController extends IntegrationController
{

    /**
     * @var Factory
     */
    private $integrationFactory;
    /**
     * @return Response
     * @throws Exception
     */
    public function productIndex()
    {

        $repository = $this->container->get('integration.repository');
        $repository->setSyliusEntityRepo($this->container->get('sylius.repository.product'));

        $dateTime = new DateTime();
        $data = $repository->getProducts();

        $response = new ResponseData();

        $response->setDateTime($dateTime);
        $response->setData($data);

        return parent::getResponse($response);
    }

    /**
     * @param array $products
     * @ParamConverter("products", class="array<IntegrationBundle\Model\Product>", converter="fos_rest.request_body")
     * @return Response
     * @throws ORMException
     */
    public function productCreateOrUpdate(array $products)
    {
        $this->integrationFactory = $this->container->get("integration.factory");
        $this->setEntityManager();

        $mainTaxon = $this->em->getRepository(Taxon::class)->findOneBy(['id' => $this->container->getParameter('default_taxon')]);
        $productTaxon = new ProductTaxon();
        $productTaxon->setTaxon($mainTaxon);

        $defaultChannel = $this->em->getRepository(Channel::class)->findAll()[0];

        $this->integrationFactory->setDefaults($defaultChannel, $productTaxon);

        $updatedCounter = 0;
        $createdCounter = 0;

        /**
         * @var Product $product
         */
        foreach ($products as $product)
        {

            /**
             * @var ProductInterface $syliusProduct
             */
            if (
                $syliusProduct = $this->em->getRepository(SyliusProduct::class)->findOneBy(["id" => $product->getId()]) or
                ($syliusProduct = $this->em->getRepository(SyliusProduct::class)->findOneBy(["id" => $product->getId1c()]))
                )
            {
                $this->update($syliusProduct, $product);
                $updatedCounter++;

            }else
            {
                $this->create($product);
                $createdCounter++;
            }
        }

        $this->em->flush();

        $response = new ResponseData();


        $data['created'] = 'created:' . $createdCounter;
        $data['updated'] = 'updated:' . $updatedCounter;
        $data['data'] = $updatedCounter + $createdCounter;

        $response->setData($data);
        return parent::getResponse($response);
    }

    /**
     * @param ProductInterface $syliusProduct
     * @param Product $product
     */
    private function update(ProductInterface $syliusProduct, Product $product)
    {

    }

    /**
     * @param Product $product
     * @throws ORMException
     */
    private function create(Product $product)
    {
        $product = $this->integrationFactory->createSyliusProduct($product);
        $this->em->persist($product);
    }

}