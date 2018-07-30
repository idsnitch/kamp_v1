<?php
/*********************************************************************************
 * Karbon Framework is a PHP5 Framework developed by Maxx Ng'ang'a
 * (C) 2016 Crysoft Dynamics Ltd
 * Karbon V 1.0
 * Maxx
 * 5/1/2017
 ********************************************************************************/

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="AppBundle\Repository\OnboardRepository")
 * @Doctrine\ORM\Mapping\Table(name="onboard")
 * @UniqueEntity(fields={"email"},message="You have already registered.")
 */
class Onboard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your full names as they appear on your ID MUST be provided")
     */
    private $firstDirectorNames;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your ID number Must Be Provided")
     */
    private $firstDirectorId;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $firstDirectorPosition;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $secondDirectorNames;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $secondDirectorPosition;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $secondDirectorId;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your company name MUST be provided")
     */
    private $companyName;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Your company type MUST be selected")
     */
    private $companyType;
    /**
     * @ORM\Column(type="string")
     * @Assert\Email(message = "Your email address MUST be provided")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Kindly read and accept the Terms and Conditions")
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
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function getFirstDirectorNames()
    {
        return $this->firstDirectorNames;
    }

    /**
     * @param mixed $firstDirectorNames
     */
    public function setFirstDirectorNames($firstDirectorNames)
    {
        $this->firstDirectorNames = $firstDirectorNames;
    }

    /**
     * @return mixed
     */
    public function getFirstDirectorId()
    {
        return $this->firstDirectorId;
    }

    /**
     * @param mixed $firstDirectorId
     */
    public function setFirstDirectorId($firstDirectorId)
    {
        $this->firstDirectorId = $firstDirectorId;
    }

    /**
     * @return mixed
     */
    public function getFirstDirectorPosition()
    {
        return $this->firstDirectorPosition;
    }

    /**
     * @param mixed $firstDirectorPosition
     */
    public function setFirstDirectorPosition($firstDirectorPosition)
    {
        $this->firstDirectorPosition = $firstDirectorPosition;
    }

    /**
     * @return mixed
     */
    public function getSecondDirectorNames()
    {
        return $this->secondDirectorNames;
    }

    /**
     * @param mixed $secondDirectorNames
     */
    public function setSecondDirectorNames($secondDirectorNames)
    {
        $this->secondDirectorNames = $secondDirectorNames;
    }

    /**
     * @return mixed
     */
    public function getSecondDirectorPosition()
    {
        return $this->secondDirectorPosition;
    }

    /**
     * @param mixed $secondDirectorPosition
     */
    public function setSecondDirectorPosition($secondDirectorPosition)
    {
        $this->secondDirectorPosition = $secondDirectorPosition;
    }

    /**
     * @return mixed
     */
    public function getSecondDirectorId()
    {
        return $this->secondDirectorId;
    }

    /**
     * @param mixed $secondDirectorId
     */
    public function setSecondDirectorId($secondDirectorId)
    {
        $this->secondDirectorId = $secondDirectorId;
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

    /**
     * @return mixed
     */
    public function getCompanyType()
    {
        return $this->companyType;
    }

    /**
     * @param mixed $companyType
     */
    public function setCompanyType($companyType)
    {
        $this->companyType = $companyType;
    }

}