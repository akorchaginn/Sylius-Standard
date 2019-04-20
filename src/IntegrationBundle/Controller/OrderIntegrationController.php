<?php


namespace IntegrationBundle\Controller;


use Symfony\Component\HttpFoundation\Response;

class OrderIntegrationController extends IntegrationController
{
    /**
     * @return Response
     */
    public function orderIndex()
    {

        $orderRepository = $this->container->get('integration.repository');
        $orderRepository->setSyliusEntityRepo($this->container->get('sylius.repository.order'));

        $data = $orderRepository->getOrders();

        return parent::getResponse($data);
    }
}