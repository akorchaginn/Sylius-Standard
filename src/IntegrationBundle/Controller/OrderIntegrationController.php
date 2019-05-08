<?php


namespace IntegrationBundle\Controller;


use DateTime;
use Exception;
use IntegrationBundle\Model\ResponseData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderIntegrationController extends IntegrationController
{
    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function orderIndex(Request $request)
    {

        $lastSynchronize = $request->headers->get('lastsync');
        $orderRepository = $this->container->get('integration.repository');
        $orderRepository->setSyliusEntityRepo($this->container->get('sylius.repository.order'));

        $dateTime = new DateTime();
        $data = $orderRepository->getOrders(new DateTime($lastSynchronize));

        $response = new ResponseData();

        $response->setDateTime($dateTime);
        $response->setData($data);

        return parent::getResponse($response);
    }
}