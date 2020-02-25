<?php


namespace IntegrationBundle\Controller;


use DateTime;
use Exception;
use IntegrationBundle\Entity\Request as IntegrationRequest;
use IntegrationBundle\Model\ResponseData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderIntegrationController
 * @package IntegrationBundle\Controller
 */
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

        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        $dateTime = new DateTime();
        $data = $orderRepository->getOrders(new DateTime($lastSynchronize));

        $response = new ResponseData();

        $response->setDateTime($dateTime);
        $response->setData($data);

        $response_orders = array_map(function ($order) {
            return $order->getId();
        }, $data);

        $integrationRequest = new IntegrationRequest();
        $integrationRequest->setLastSynchronizeInput(new DateTime($lastSynchronize))
            ->setLastSynchronizeOutput($dateTime)
            ->setResponseOrders(json_encode($response_orders));

        $entityManager->persist($integrationRequest);
        $entityManager->flush();

        return parent::getResponse($response);
    }
}