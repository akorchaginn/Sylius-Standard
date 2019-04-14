<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 14:55
 */

namespace IntegrationBundle\Model;

use DateTimeInterface;
use \Sylius\Component\Customer\Model\CustomerInterface;

class Customer
{
    use IntegrationTrait;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var DateTimeInterface|null
     */
    private $birthday;

    /**
     * @var string
     */
    private $gender = CustomerInterface::UNKNOWN_GENDER;

    /**
     * @var string|null
     */
    private $phone_number;

    /**
     * @param null|string $email
     *
     * @return Customer
     */
    public function setEmail(?string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param null|string $firstName
     *
     * @return Customer
     */
    public function setFirstName(?string $firstName): Customer
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param null|string $lastName
     *
     * @return Customer
     */
    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param DateTimeInterface|null $birthday
     *
     * @return Customer
     */
    public function setBirthday(?DateTimeInterface $birthday): Customer
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @param string $gender
     *
     * @return Customer
     */
    public function setGender(string $gender): Customer
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @param null|string $phone_number
     *
     * @return Customer
     */
    public function setPhoneNumber(?string $phone_number): Customer
    {
        $this->phone_number = $phone_number;
        return $this;
    }

}