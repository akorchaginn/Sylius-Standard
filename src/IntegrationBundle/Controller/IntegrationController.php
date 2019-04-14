<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:52
 */

namespace IntegrationBundle\Controller;

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
     * @param $data
     *
     * @return Response
     */
    protected function getResponse($data)
    {
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
}