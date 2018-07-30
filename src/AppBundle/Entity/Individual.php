<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 3/7/2018
 * Time: 6:14 PM
 ********************************************************************************/

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="AppBundle\Repository\IndividualRepository")
 * @Doctrine\ORM\Mapping\Table(name="individual")
 * @UniqueEntity(fields={"email"},message="You have already registered.")
 */
class Individual
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your first name MUST be provided")
     */
    private $firstName;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your middle name MUST be provided")
     */
    private $middleName;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your last name MUST be provided")
     */
    private $lastName;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "This value should not be blank")
     */
    private $idNumber;
    /**
     * @ORM\Column(type="string")
     * @Assert\Email(message = "Your email address MUST be provided")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Kindly accept the Terms and Conditions")
     */
    private $termsOfService;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    /**
     * @return mixed
     */
    public function getIdNumber()
    {
        return $this->idNumber;
    }

    /**
     * @param mixed $idNumber
     */
    public function setIdNumber($idNumber)
    {
        $this->idNumber = $idNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTermsOfService()
    {
        return $this->termsOfService;
    }

    /**
     * @param mixed $termsOfService
     */
    public function setTermsOfService($termsOfService)
    {
        $this->termsOfService = $termsOfService;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getFullName(){
        return trim($this->getFirstName() . ' ' . $this->getLastName());
    }


}