<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\CustomerRepository as BaseRepository;
use IntegrationBundle\Model\CustomerFactory;

/**
 * Class CustomerRepository
 * @package IntegrationBundle\Repository
 */
class CustomerRepository
{
    /**
     * @var BaseRepository
     */
    private $syliusCustomerRepository;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * CustomerRepository constructor.
     *
     * @param CustomerFactory $customerFactory
     */
    public function __construct(CustomerFactory $customerFactory)
    {
        $this->customerFactory = $customerFactory;
    }


    public function setSyliusCustomerRepo($customerRepository)
    {
        $this->syliusCustomerRepository = $customerRepository;
    }

    /**
     * @return array|null
     */
    public function getCustomers()
    {
        $integrationCustomers = [];

        $syliusCustomers = $this->syliusCustomerRepository->findAll();

        /**
         * @var \Sylius\Component\Customer\Model\CustomerInterface $customer
         */
        foreach ($syliusCustomers as $customer)
        {
            /**
             * @var \IntegrationBundle\Model\Customer
             */
            $integrationCustomer = $this->customerFactory->createCustomer();

            $integrationCustomer->setId($customer->getId())
                ->setFirstName($customer->getFirstName())
                ->setLastName($customer->getLastName())
                ->setGender($customer->getGender())
                ->setBirthday($customer->getBirthday())
                ->setEmail($customer->getEmail())
                ->setPhoneNumber($customer->getPhoneNumber());

            $integrationCustomers[] = $integrationCustomer;
        }

        return $integrationCustomers;
    }
}