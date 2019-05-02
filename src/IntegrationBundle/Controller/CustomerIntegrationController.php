<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 16:34
 */

namespace IntegrationBundle\Controller;
;

use IntegrationBundle\Entity\Customer as CustomerEntity;
use IntegrationBundle\Model\Customer;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\Core\Model\ShopUser;
use Sylius\Component\User\Security\Generator\UniqueTokenGenerator;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     */
    public function customerIndex()
    {

        $customerRepository = $this->container->get('integration.repository');
        $customerRepository->setSyliusEntityRepo($this->container->get('sylius.repository.customer'));

        $data = $customerRepository->getCustomers();

        $response['data'] = $data;
        return parent::getResponse($response);
    }

    /**
     * @ParamConverter("customers", class="array<IntegrationBundle\Model\Customer>", converter="fos_rest.request_body")
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
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
            if ($syliusCustomer = $this->em->getRepository(CustomerEntity::class)->findOneBy(['id' => $customer->getId()]))
            {
                $this->update($syliusCustomer, $customer);
                $updatedCounter++;
            }elseif ($customer->getId1c() && $syliusCustomer = $this->em->getRepository(CustomerEntity::class)->findOneBy(['id_1c' => $customer->getId1c()]))
            {
                $this->update($syliusCustomer, $customer);
                $updatedCounter++;
            }else
            {
                $this->create($customer);
                $createdCounter++;
            }


        }

        $this->em->flush();

        $response['created'] = 'created:' . $createdCounter;
        $response['updated'] = 'updated:' . $updatedCounter;
        $response['data'] = $updatedCounter + $createdCounter;
        return parent::getResponse($response);
    }

    /**
     * @param CustomerEntity $syliusCustomer
     * @param Customer $customer
     * @throws \Doctrine\ORM\ORMException
     */
    private function update(CustomerEntity $syliusCustomer, Customer $customer)
    {
        $syliusCustomer->setId1c($customer->getId1c());
        $syliusCustomer->setEmail($customer->getEmail());
        $syliusCustomer->setBirthday($customer->getBirthday());
        $syliusCustomer->setFirstName($customer->getFirstName());
        $syliusCustomer->setLastName($customer->getLastName());
        $syliusCustomer->setGender($customer->getGender());
        $syliusCustomer->setPhoneNumber($customer->getPhoneNumber());

        $this->em->persist($syliusCustomer);
    }

    /**
     * @todo Добавить валидатор email
     * @param Customer $customer
     * @throws \Doctrine\ORM\ORMException
     */
    private function create(Customer $customer)
    {
        /**
         * @var CustomerEntity $syliusCustomer
         */
        $syliusCustomer = $this->container->get('sylius.factory.customer')->createNew(CustomerEntity::class);

        /**
         * @var ShopUser $syliusShopUser
         */
        $syliusShopUser = $this->container->get('sylius.factory.shop_user')->createNew(ShopUser::class);

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
        $syliusShopUser->setPlainPassword('1z2s#E4r%G^N');
        $syliusShopUser->setPasswordRequestedAt(new \DateTime());
        $syliusShopUser->setEmailVerificationToken($this->emailTokenGenerator->generate());
        $syliusShopUser->setPasswordResetToken($this->passwordTokenGenerator->generate());


        $this->em->persist($syliusShopUser);
        $this->em->flush();

        $eventDispatcher = $this->container->get('event_dispatcher');
        $eventDispatcher->dispatch(UserEvents::REQUEST_VERIFICATION_TOKEN, new GenericEvent($syliusShopUser));
        $eventDispatcher->dispatch(UserEvents::REQUEST_RESET_PASSWORD_TOKEN, new GenericEvent($syliusShopUser));
    }
}