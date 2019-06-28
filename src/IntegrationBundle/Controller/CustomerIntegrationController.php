<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:34
 */

namespace IntegrationBundle\Controller;
;

use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use IntegrationBundle\Entity\CustomerInterface as CustomerInterface;
use IntegrationBundle\Model\Customer;
use IntegrationBundle\Model\ResponseData;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\Core\Model\ShopUser;
use Sylius\Component\User\Security\Generator\UniqueTokenGenerator;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class CustomerIntegrationController
 * @package IntegrationBundle\Controller
 */
class CustomerIntegrationController extends IntegrationController
{
    /**
     * @var UniqueTokenGenerator $emailTokenGenerator
     */
    private $emailTokenGenerator;

    /**
     * @var UniqueTokenGenerator $passwordTokenGenerator
     */
    private $passwordTokenGenerator;

    /**
     * @return Response
     * @throws Exception
     */
    public function customerIndex()
    {

        $customerRepository = $this->container->get('integration.repository');
        $customerRepository->setSyliusEntityRepo($this->container->get('sylius.repository.customer'));

        $dateTime = new DateTime();
        $data = $customerRepository->getCustomers();

        $response = new ResponseData();

        $response->setDateTime($dateTime);
        $response->setData($data);
        return parent::getResponse($response);
    }

    /**
     * @param array $customers
     * @ParamConverter("customers", class="array<IntegrationBundle\Model\Customer>", converter="fos_rest.request_body")
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function customerCreateOrUpdate(array $customers)
    {
        $this->emailTokenGenerator = $this->container->get('sylius.shop_user.token_generator.email_verification');
        $this->passwordTokenGenerator = $this->container->get('sylius.shop_user.token_generator.password_reset');

        $updatedCounter = 0;
        $createdCounter = 0;
        $this->setEntityManager();
        /**
         * @var Customer $customer
         */
        foreach ($customers as $customer)
        {
            /**
             * @var CustomerInterface $syliusCustomer
             */
            if ($syliusCustomer = $this->entityManager->getRepository(CustomerInterface::class)->findOneBy(['id' => $customer->getId()]))
            {
                $this->update($syliusCustomer, $customer);
                $updatedCounter++;
            }elseif ($customer->getId1c() && $syliusCustomer = $this->entityManager->getRepository(CustomerInterface::class)->findOneBy(['id_1c' => $customer->getId1c()]))
            {
                $this->update($syliusCustomer, $customer);
                $updatedCounter++;
            }else
            {
                $this->create($customer);
                $createdCounter++;
            }


        }

        $this->entityManager->flush();

        $response['created'] = 'created:' . $createdCounter;
        $response['updated'] = 'updated:' . $updatedCounter;
        $response['data'] = $updatedCounter + $createdCounter;
        return parent::getResponse($response);
    }

    /**
     * @param CustomerInterface $syliusCustomer
     * @param Customer $customer
     * @throws ORMException
     */
    private function update(CustomerInterface $syliusCustomer, Customer $customer)
    {
        $syliusCustomer->setId1c($customer->getId1c());
        $syliusCustomer->setEmail($customer->getEmail());
        $syliusCustomer->setBirthday($customer->getBirthday());
        $syliusCustomer->setFirstName($customer->getFirstName());
        $syliusCustomer->setLastName($customer->getLastName());
        $syliusCustomer->setGender($customer->getGender());
        $syliusCustomer->setPhoneNumber($customer->getPhoneNumber());

        $this->entityManager->persist($syliusCustomer);
    }

    /**
     * @todo Добавить валидатор email
     * @param Customer $customer
     * @throws ORMException
     */
    private function create(Customer $customer)
    {
        /**
         * @var CustomerInterface $syliusCustomer
         */
        $syliusCustomer = $this->container->get('sylius.factory.customer')->createNew();

        /**
         * @var ShopUser $syliusShopUser
         */
        $syliusShopUser = $this->container->get('sylius.factory.shop_user')->createNew();

        $syliusCustomer->setId1c($customer->getId1c());
        $syliusCustomer->setEmail($customer->getEmail());
        $syliusCustomer->setBirthday($customer->getBirthday());
        $syliusCustomer->setFirstName($customer->getFirstName());
        $syliusCustomer->setLastName($customer->getLastName());
        $syliusCustomer->setGender($customer->getGender());
        $syliusCustomer->setPhoneNumber($customer->getPhoneNumber());

        $syliusShopUser->setCustomer($syliusCustomer);
        $syliusShopUser->setEmail($customer->getEmail());
        $syliusShopUser->setUsername($customer->getEmail());
        $syliusShopUser->setPlainPassword('b/vbb+B8G=Y54_yP');
        $syliusShopUser->setPasswordRequestedAt(new DateTime());
        $syliusShopUser->setEmailVerificationToken($this->emailTokenGenerator->generate());
        $syliusShopUser->setPasswordResetToken($this->passwordTokenGenerator->generate());


        $this->entityManager->persist($syliusShopUser);
        $this->entityManager->flush();

        $eventDispatcher = $this->container->get('event_dispatcher');
        $eventDispatcher->dispatch(UserEvents::REQUEST_VERIFICATION_TOKEN, new GenericEvent($syliusShopUser));
        $eventDispatcher->dispatch(UserEvents::REQUEST_RESET_PASSWORD_TOKEN, new GenericEvent($syliusShopUser));
    }
}