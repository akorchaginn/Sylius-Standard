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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function returnResponse($data)
    {
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
}