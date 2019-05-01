<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:52
 */

namespace IntegrationBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param Request $request
 *
 * @return Response
 */
class IntegrationController extends FOSRestController
{

    /**
     * @var EntityManager $em
     */
    protected $em;

    public function setEntityManager()
    {
        $this->em = $this->container->get('doctrine.orm.entity_manager');
    }

    /**
     * @param $data
     *
     * @return Response
     */
    protected function getResponse($data)
    {
        $statusCode = !empty($data['data']) ? 200 : 204;

        $view = $this->view($data, $statusCode);
        return $this->handleView($view);
    }
}