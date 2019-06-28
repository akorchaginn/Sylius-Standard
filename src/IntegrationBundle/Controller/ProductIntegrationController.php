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
use IntegrationBundle\Model\Factory;
use IntegrationBundle\Model\Product;
use IntegrationBundle\Model\ResponseData;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ProductTaxon;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Core\Model\TaxonInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ProductIntegrationController
 * @package IntegrationBundle\Controller
 */
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
        $counter= 0;
        $this->integrationFactory = $this->container->get("integration.factory");
        $this->setEntityManager();

        /**
         * @var TaxonInterface $mainTaxon
         */
        $mainTaxon = $this->entityManager->getRepository(Taxon::class)->findOneBy(['id' => $this->container->getParameter('default_taxon')]);
        $productTaxon = new ProductTaxon();
        $productTaxon->setTaxon($mainTaxon);

        $defaultChannel = $this->entityManager->getRepository(Channel::class)->findAll()[0];
        $this->integrationFactory->setDefaults($defaultChannel, $productTaxon);

        /**
         * @var Product $product
         */
        foreach ($products as $product)
        {
            $product = $this->integrationFactory->createSyliusProduct($product);
            $this->entityManager->persist($product);

            $counter++;
            if ($counter >= 50)
            {
                $this->entityManager->flush();
                $counter = 0;
            }
        }
        $this->entityManager->flush();

        $dateTime = new DateTime();
        $response = new ResponseData();

        $response->setDateTime($dateTime);
        $response->setData(["ok"]);
        return parent::getResponse($response);
    }
}