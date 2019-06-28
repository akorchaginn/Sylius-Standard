<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:52
 */

namespace IntegrationBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use IntegrationBundle\Model\ResponseData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param Request $request
 *
 * @return Response
 */
class IntegrationController extends AbstractFOSRestController
{

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    public function setEntityManager()
    {
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
    }

    /**
     * @param ResponseData $responseData
     * @return Response
     */
    protected function getResponse(ResponseData $responseData)
    {
        $statusCode = !empty($responseData->getData()) ? 200 : 204;

        $view = $this->view($responseData, $statusCode);
        return $this->handleView($view);
    }
}