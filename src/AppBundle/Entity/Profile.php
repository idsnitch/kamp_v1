<?php
/*********************************************************************************
 * Karbon Framework is a PHP5 Framework developed by Maxx Ng'ang'a
 * (C) 2016 Crysoft Dynamics Ltd
 * Karbon V 1.0
 * Maxx
 * 5/1/2017
 ********************************************************************************/

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 * @ORM\Table(name="profile")
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $progress="Initial";
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $applicantName;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $producerName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $memberNumber;
    /**
     * @ORM\Column(type="date",nullable=true)
     * @Assert\NotBlank()
     */
    private $dateOfBirth;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $idNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $itaxPin;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $gender;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $status;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $physicalAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $city;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $county;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $postalAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $postalCode;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $mobileNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $telephoneNumber;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $emailAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $emailAddress2;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $website;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $paymentMpesaNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $accountName;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $accountNumber;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $bank;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $bankBranch;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $bankCode;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $swiftCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCollectingSocietiesMember=false;
    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $collectingSocieties;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinFirstName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinMiddleName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinLastName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinRelationship;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinIdNumber;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $kinDateOfBirth;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinGender;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinPhysicalAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinCity;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinCounty;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinPostalAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinPostalCode;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinTelephoneNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinMobileNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinEmailAddress;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isKinMinor=false;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $kinGuardian;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinFirstName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinMiddleName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinLastName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinRelationship;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinIdNumber;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $otherKinDateOfBirth;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinGender;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinPhysicalAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinCity;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinCounty;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinPostalAddress;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinPostalCode;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinTelephoneNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinMobileNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinEmailAddress;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isOtherKinMinor=false;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $otherKinGuardian;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $termsOfService;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $idemnifyFirstName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $idemnifyLastName;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $idemnifyAt;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $transactionId;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isPaid;
    /**
     * @ORM\Column(type="boolean")
     */
    private $mpesaProcessed=false;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mpesaConfirmationCode;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $mpesaPaymentDate;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mpesaStatus;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mpesaDescription;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mpesaNumber;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mpesaAmount;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mpesaVerificationCode;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isUrlvalid;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $profileStatus;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $statusDescription;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isMembershipApproved;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $membershipApprovedBy;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $membershipApprovedAt;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isBoardApproved;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isBoardRejected;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $boardRejectionAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $boardRejectionBy;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $boardRejectionReason;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $nrBoardApprovals;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $boardApprover1;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $boardApprover2;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $boardApprover3;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $boardApprovalStatus1;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $boardApprovalStatus2;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $boardApprovalStatus3;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $approval1At;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $approval2At;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $approval3At;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
       private $createdAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $processedBy;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $processedAt;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $accountCreated;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Documents",mappedBy="whichProfile",fetch="EXTRA_LAZY")
     */
    private $profileDocuments;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Music",mappedBy="whichProfile",fetch="EXTRA_LAZY")
     */
    private $profileSamples;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $referenceId;
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User",mappedBy="profile")
     */
    private $user;

    function __construct()
    {
        $this->profileDocuments = new ArrayCollection();
        $this->profileSamples = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * @param mixed $referenceId
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;
    }

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
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param mixed $progress
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return mixed
     */
    public function getApplicantName()
    {
        return $this->applicantName;
    }

    /**
     * @param mixed $applicantName
     */
    public function setApplicantName($applicantName)
    {
        $this->applicantName = $applicantName;
    }

    /**
     * @return mixed
     */
    public function getProducerName()
    {
        return $this->producerName;
    }

    /**
     * @param mixed $producerName
     */
    public function setProducerName($producerName)
    {
        $this->producerName = $producerName;
    }

    /**
     * @return mixed
     */
    public function getMemberNumber()
    {
        return $this->memberNumber;
    }

    /**
     * @param mixed $memberNumber
     */
    public function setMemberNumber($memberNumber)
    {
        $this->memberNumber = $memberNumber;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
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
    public function getItaxPin()
    {
        return $this->itaxPin;
    }

    /**
     * @param mixed $itaxPin
     */
    public function setItaxPin($itaxPin)
    {
        $this->itaxPin = $itaxPin;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPhysicalAddress()
    {
        return $this->physicalAddress;
    }

    /**
     * @param mixed $physicalAddress
     */
    public function setPhysicalAddress($physicalAddress)
    {
        $this->physicalAddress = $physicalAddress;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param mixed $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }

    /**
     * @return mixed
     */
    public function getPostalAddress()
    {
        return $this->postalAddress;
    }

    /**
     * @param mixed $postalAddress
     */
    public function setPostalAddress($postalAddress)
    {
        $this->postalAddress = $postalAddress;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param mixed $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return mixed
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * @param mixed $telephoneNumber
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param mixed $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress2()
    {
        return $this->emailAddress2;
    }

    /**
     * @param mixed $emailAddress2
     */
    public function setEmailAddress2($emailAddress2)
    {
        $this->emailAddress2 = $emailAddress2;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getPaymentMpesaNumber()
    {
        return $this->paymentMpesaNumber;
    }

    /**
     * @param mixed $paymentMpesaNumber
     */
    public function setPaymentMpesaNumber($paymentMpesaNumber)
    {
        $this->paymentMpesaNumber = $paymentMpesaNumber;
    }

    /**
     * @return mixed
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @param mixed $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param mixed $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param mixed $bank
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    /**
     * @return mixed
     */
    public function getBankBranch()
    {
        return $this->bankBranch;
    }

    /**
     * @param mixed $bankBranch
     */
    public function setBankBranch($bankBranch)
    {
        $this->bankBranch = $bankBranch;
    }

    /**
     * @return mixed
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @param mixed $bankCode
     */
    public function setBankCode($bankCode)
    {
        $this->bankCode = $bankCode;
    }



    /**
     * @return mixed
     */
    public function getSwiftCode()
    {
        return $this->swiftCode;
    }

    /**
     * @param mixed $swiftCode
     */
    public function setSwiftCode($swiftCode)
    {
        $this->swiftCode = $swiftCode;
    }

    /**
     * @return mixed
     */
    public function getIsCollectingSocietiesMember()
    {
        return $this->isCollectingSocietiesMember;
    }

    /**
     * @param mixed $isCollectingSocietiesMember
     */
    public function setIsCollectingSocietiesMember($isCollectingSocietiesMember)
    {
        $this->isCollectingSocietiesMember = $isCollectingSocietiesMember;
    }

    /**
     * @return mixed
     */
    public function getCollectingSocieties()
    {
        return $this->collectingSocieties;
    }

    /**
     * @param mixed $collectingSocieties
     */
    public function setCollectingSocieties($collectingSocieties)
    {
        $this->collectingSocieties = $collectingSocieties;
    }

    /**
     * @return mixed
     */
    public function getKinFirstName()
    {
        return $this->kinFirstName;
    }

    /**
     * @param mixed $kinFirstName
     */
    public function setKinFirstName($kinFirstName)
    {
        $this->kinFirstName = $kinFirstName;
    }

    /**
     * @return mixed
     */
    public function getKinMiddleName()
    {
        return $this->kinMiddleName;
    }

    /**
     * @param mixed $kinMiddleName
     */
    public function setKinMiddleName($kinMiddleName)
    {
        $this->kinMiddleName = $kinMiddleName;
    }

    /**
     * @return mixed
     */
    public function getKinLastName()
    {
        return $this->kinLastName;
    }

    /**
     * @param mixed $kinLastName
     */
    public function setKinLastName($kinLastName)
    {
        $this->kinLastName = $kinLastName;
    }

    /**
     * @return mixed
     */
    public function getKinRelationship()
    {
        return $this->kinRelationship;
    }

    /**
     * @param mixed $kinRelationship
     */
    public function setKinRelationship($kinRelationship)
    {
        $this->kinRelationship = $kinRelationship;
    }

    /**
     * @return mixed
     */
    public function getKinIdNumber()
    {
        return $this->kinIdNumber;
    }

    /**
     * @param mixed $kinIdNumber
     */
    public function setKinIdNumber($kinIdNumber)
    {
        $this->kinIdNumber = $kinIdNumber;
    }

    /**
     * @return mixed
     */
    public function getKinDateOfBirth()
    {
        return $this->kinDateOfBirth;
    }

    /**
     * @param mixed $kinDateOfBirth
     */
    public function setKinDateOfBirth($kinDateOfBirth)
    {
        $this->kinDateOfBirth = $kinDateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getKinGender()
    {
        return $this->kinGender;
    }

    /**
     * @param mixed $kinGender
     */
    public function setKinGender($kinGender)
    {
        $this->kinGender = $kinGender;
    }

    /**
     * @return mixed
     */
    public function getKinPhysicalAddress()
    {
        return $this->kinPhysicalAddress;
    }

    /**
     * @param mixed $kinPhysicalAddress
     */
    public function setKinPhysicalAddress($kinPhysicalAddress)
    {
        $this->kinPhysicalAddress = $kinPhysicalAddress;
    }

    /**
     * @return mixed
     */
    public function getKinCity()
    {
        return $this->kinCity;
    }

    /**
     * @param mixed $kinCity
     */
    public function setKinCity($kinCity)
    {
        $this->kinCity = $kinCity;
    }

    /**
     * @return mixed
     */
    public function getKinCounty()
    {
        return $this->kinCounty;
    }

    /**
     * @param mixed $kinCounty
     */
    public function setKinCounty($kinCounty)
    {
        $this->kinCounty = $kinCounty;
    }

    /**
     * @return mixed
     */
    public function getKinPostalAddress()
    {
        return $this->kinPostalAddress;
    }

    /**
     * @param mixed $kinPostalAddress
     */
    public function setKinPostalAddress($kinPostalAddress)
    {
        $this->kinPostalAddress = $kinPostalAddress;
    }

    /**
     * @return mixed
     */
    public function getKinPostalCode()
    {
        return $this->kinPostalCode;
    }

    /**
     * @param mixed $kinPostalCode
     */
    public function setKinPostalCode($kinPostalCode)
    {
        $this->kinPostalCode = $kinPostalCode;
    }

    /**
     * @return mixed
     */
    public function getKinTelephoneNumber()
    {
        return $this->kinTelephoneNumber;
    }

    /**
     * @param mixed $kinTelephoneNumber
     */
    public function setKinTelephoneNumber($kinTelephoneNumber)
    {
        $this->kinTelephoneNumber = $kinTelephoneNumber;
    }

    /**
     * @return mixed
     */
    public function getKinMobileNumber()
    {
        return $this->kinMobileNumber;
    }

    /**
     * @param mixed $kinMobileNumber
     */
    public function setKinMobileNumber($kinMobileNumber)
    {
        $this->kinMobileNumber = $kinMobileNumber;
    }

    /**
     * @return mixed
     */
    public function getKinEmailAddress()
    {
        return $this->kinEmailAddress;
    }

    /**
     * @param mixed $kinEmailAddress
     */
    public function setKinEmailAddress($kinEmailAddress)
    {
        $this->kinEmailAddress = $kinEmailAddress;
    }

    /**
     * @return mixed
     */
    public function getIsKinMinor()
    {
        return $this->isKinMinor;
    }

    /**
     * @param mixed $isKinMinor
     */
    public function setIsKinMinor($isKinMinor)
    {
        $this->isKinMinor = $isKinMinor;
    }

    /**
     * @return mixed
     */
    public function getKinGuardian()
    {
        return $this->kinGuardian;
    }

    /**
     * @param mixed $kinGuardian
     */
    public function setKinGuardian($kinGuardian)
    {
        $this->kinGuardian = $kinGuardian;
    }

    /**
     * @return mixed
     */
    public function getOtherKinFirstName()
    {
        return $this->otherKinFirstName;
    }

    /**
     * @param mixed $otherKinFirstName
     */
    public function setOtherKinFirstName($otherKinFirstName)
    {
        $this->otherKinFirstName = $otherKinFirstName;
    }

    /**
     * @return mixed
     */
    public function getOtherKinMiddleName()
    {
        return $this->otherKinMiddleName;
    }

    /**
     * @param mixed $otherKinMiddleName
     */
    public function setOtherKinMiddleName($otherKinMiddleName)
    {
        $this->otherKinMiddleName = $otherKinMiddleName;
    }

    /**
     * @return mixed
     */
    public function getOtherKinLastName()
    {
        return $this->otherKinLastName;
    }

    /**
     * @param mixed $otherKinLastName
     */
    public function setOtherKinLastName($otherKinLastName)
    {
        $this->otherKinLastName = $otherKinLastName;
    }

    /**
     * @return mixed
     */
    public function getOtherKinRelationship()
    {
        return $this->otherKinRelationship;
    }

    /**
     * @param mixed $otherKinRelationship
     */
    public function setOtherKinRelationship($otherKinRelationship)
    {
        $this->otherKinRelationship = $otherKinRelationship;
    }

    /**
     * @return mixed
     */
    public function getOtherKinIdNumber()
    {
        return $this->otherKinIdNumber;
    }

    /**
     * @param mixed $otherKinIdNumber
     */
    public function setOtherKinIdNumber($otherKinIdNumber)
    {
        $this->otherKinIdNumber = $otherKinIdNumber;
    }

    /**
     * @return mixed
     */
    public function getOtherKinDateOfBirth()
    {
        return $this->otherKinDateOfBirth;
    }

    /**
     * @param mixed $otherKinDateOfBirth
     */
    public function setOtherKinDateOfBirth($otherKinDateOfBirth)
    {
        $this->otherKinDateOfBirth = $otherKinDateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getOtherKinGender()
    {
        return $this->otherKinGender;
    }

    /**
     * @param mixed $otherKinGender
     */
    public function setOtherKinGender($otherKinGender)
    {
        $this->otherKinGender = $otherKinGender;
    }

    /**
     * @return mixed
     */
    public function getOtherKinPhysicalAddress()
    {
        return $this->otherKinPhysicalAddress;
    }

    /**
     * @param mixed $otherKinPhysicalAddress
     */
    public function setOtherKinPhysicalAddress($otherKinPhysicalAddress)
    {
        $this->otherKinPhysicalAddress = $otherKinPhysicalAddress;
    }

    /**
     * @return mixed
     */
    public function getOtherKinCity()
    {
        return $this->otherKinCity;
    }

    /**
     * @param mixed $otherKinCity
     */
    public function setOtherKinCity($otherKinCity)
    {
        $this->otherKinCity = $otherKinCity;
    }

    /**
     * @return mixed
     */
    public function getOtherKinCounty()
    {
        return $this->otherKinCounty;
    }

    /**
     * @param mixed $otherKinCounty
     */
    public function setOtherKinCounty($otherKinCounty)
    {
        $this->otherKinCounty = $otherKinCounty;
    }

    /**
     * @return mixed
     */
    public function getOtherKinPostalAddress()
    {
        return $this->otherKinPostalAddress;
    }

    /**
     * @param mixed $otherKinPostalAddress
     */
    public function setOtherKinPostalAddress($otherKinPostalAddress)
    {
        $this->otherKinPostalAddress = $otherKinPostalAddress;
    }

    /**
     * @return mixed
     */
    public function getOtherKinPostalCode()
    {
        return $this->otherKinPostalCode;
    }

    /**
     * @param mixed $otherKinPostalCode
     */
    public function setOtherKinPostalCode($otherKinPostalCode)
    {
        $this->otherKinPostalCode = $otherKinPostalCode;
    }

    /**
     * @return mixed
     */
    public function getOtherKinTelephoneNumber()
    {
        return $this->otherKinTelephoneNumber;
    }

    /**
     * @param mixed $otherKinTelephoneNumber
     */
    public function setOtherKinTelephoneNumber($otherKinTelephoneNumber)
    {
        $this->otherKinTelephoneNumber = $otherKinTelephoneNumber;
    }

    /**
     * @return mixed
     */
    public function getOtherKinMobileNumber()
    {
        return $this->otherKinMobileNumber;
    }

    /**
     * @param mixed $otherKinMobileNumber
     */
    public function setOtherKinMobileNumber($otherKinMobileNumber)
    {
        $this->otherKinMobileNumber = $otherKinMobileNumber;
    }

    /**
     * @return mixed
     */
    public function getOtherKinEmailAddress()
    {
        return $this->otherKinEmailAddress;
    }

    /**
     * @param mixed $otherKinEmailAddress
     */
    public function setOtherKinEmailAddress($otherKinEmailAddress)
    {
        $this->otherKinEmailAddress = $otherKinEmailAddress;
    }

    /**
     * @return mixed
     */
    public function getIsOtherKinMinor()
    {
        return $this->isOtherKinMinor;
    }

    /**
     * @param mixed $isotherKinMinor
     */
    public function setIsOtherKinMinor($isOtherKinMinor)
    {
        $this->isOtherKinMinor = $isOtherKinMinor;
    }

    /**
     * @return mixed
     */
    public function getOtherKinGuardian()
    {
        return $this->otherKinGuardian;
    }

    /**
     * @param mixed $otherKinGuardian
     */
    public function setOtherKinGuardian($otherKinGuardian)
    {
        $this->otherKinGuardian = $otherKinGuardian;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return mixed
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * @param mixed $isPaid
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;
    }

    /**
     * @return mixed
     */
    public function getMpesaProcessed()
    {
        return $this->mpesaProcessed;
    }

    /**
     * @param mixed $mpesaProcessed
     */
    public function setMpesaProcessed($mpesaProcessed)
    {
        $this->mpesaProcessed = $mpesaProcessed;
    }

    /**
     * @return mixed
     */
    public function getMpesaConfirmationCode()
    {
        return $this->mpesaConfirmationCode;
    }

    /**
     * @param mixed $mpesaConfirmationCode
     */
    public function setMpesaConfirmationCode($mpesaConfirmationCode)
    {
        $this->mpesaConfirmationCode = $mpesaConfirmationCode;
    }

    /**
     * @return mixed
     */
    public function getMpesaPaymentDate()
    {
        return $this->mpesaPaymentDate;
    }

    /**
     * @param mixed $mpesaPaymentDate
     */
    public function setMpesaPaymentDate($mpesaPaymentDate)
    {
        $this->mpesaPaymentDate = $mpesaPaymentDate;
    }

    /**
     * @return mixed
     */
    public function getMpesaStatus()
    {
        return $this->mpesaStatus;
    }

    /**
     * @param mixed $mpesaStatus
     */
    public function setMpesaStatus($mpesaStatus)
    {
        $this->mpesaStatus = $mpesaStatus;
    }

    /**
     * @return mixed
     */
    public function getMpesaDescription()
    {
        return $this->mpesaDescription;
    }

    /**
     * @param mixed $mpesaDescription
     */
    public function setMpesaDescription($mpesaDescription)
    {
        $this->mpesaDescription = $mpesaDescription;
    }

    /**
     * @return mixed
     */
    public function getMpesaNumber()
    {
        return $this->mpesaNumber;
    }

    /**
     * @param mixed $mpesaNumber
     */
    public function setMpesaNumber($mpesaNumber)
    {
        $this->mpesaNumber = $mpesaNumber;
    }

    /**
     * @return mixed
     */
    public function getMpesaAmount()
    {
        return $this->mpesaAmount;
    }

    /**
     * @param mixed $mpesaAmount
     */
    public function setMpesaAmount($mpesaAmount)
    {
        $this->mpesaAmount = $mpesaAmount;
    }

    /**
     * @return mixed
     */
    public function getMpesaVerificationCode()
    {
        return $this->mpesaVerificationCode;
    }

    /**
     * @param mixed $mpesaVerificationCode
     */
    public function setMpesaVerificationCode($mpesaVerificationCode)
    {
        $this->mpesaVerificationCode = $mpesaVerificationCode;
    }

    /**
     * @return mixed
     */
    public function getIsUrlvalid()
    {
        return $this->isUrlvalid;
    }

    /**
     * @param mixed $isUrlvalid
     */
    public function setIsUrlvalid($isUrlvalid)
    {
        $this->isUrlvalid = $isUrlvalid;
    }

    /**
     * @return mixed
     */
    public function getProfileStatus()
    {
        return $this->profileStatus;
    }

    /**
     * @param mixed $profileStatus
     */
    public function setProfileStatus($profileStatus)
    {
        $this->profileStatus = $profileStatus;
    }

    /**
     * @return mixed
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * @param mixed $statusDescription
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;
    }

    /**
     * @return mixed
     */
    public function getIsMembershipApproved()
    {
        return $this->isMembershipApproved;
    }

    /**
     * @param mixed $isMembershipApproved
     */
    public function setIsMembershipApproved($isMembershipApproved)
    {
        $this->isMembershipApproved = $isMembershipApproved;
    }

    /**
     * @return mixed
     */
    public function getMembershipApprovedBy()
    {
        return $this->membershipApprovedBy;
    }

    /**
     * @param mixed $membershipApprovedBy
     */
    public function setMembershipApprovedBy($membershipApprovedBy)
    {
        $this->membershipApprovedBy = $membershipApprovedBy;
    }

    /**
     * @return mixed
     */
    public function getMembershipApprovedAt()
    {
        return $this->membershipApprovedAt;
    }

    /**
     * @param mixed $membershipApprovedAt
     */
    public function setMembershipApprovedAt($membershipApprovedAt)
    {
        $this->membershipApprovedAt = $membershipApprovedAt;
    }

    /**
     * @return mixed
     */
    public function getIsBoardApproved()
    {
        return $this->isBoardApproved;
    }

    /**
     * @param mixed $isBoardApproved
     */
    public function setIsBoardApproved($isBoardApproved)
    {
        $this->isBoardApproved = $isBoardApproved;
    }

    /**
     * @return mixed
     */
    public function getIsBoardRejected()
    {
        return $this->isBoardRejected;
    }

    /**
     * @param mixed $isBoardRejected
     */
    public function setIsBoardRejected($isBoardRejected)
    {
        $this->isBoardRejected = $isBoardRejected;
    }

    /**
     * @return mixed
     */
    public function getBoardRejectionAt()
    {
        return $this->boardRejectionAt;
    }

    /**
     * @param mixed $boardRejectionAt
     */
    public function setBoardRejectionAt($boardRejectionAt)
    {
        $this->boardRejectionAt = $boardRejectionAt;
    }

    /**
     * @return mixed
     */
    public function getBoardRejectionBy()
    {
        return $this->boardRejectionBy;
    }

    /**
     * @param mixed $boardRejectionBy
     */
    public function setBoardRejectionBy($boardRejectionBy)
    {
        $this->boardRejectionBy = $boardRejectionBy;
    }

    /**
     * @return mixed
     */
    public function getBoardRejectionReason()
    {
        return $this->boardRejectionReason;
    }

    /**
     * @param mixed $boardRejectionReason
     */
    public function setBoardRejectionReason($boardRejectionReason)
    {
        $this->boardRejectionReason = $boardRejectionReason;
    }

    /**
     * @return mixed
     */
    public function getNrBoardApprovals()
    {
        return $this->nrBoardApprovals;
    }

    /**
     * @param mixed $nrBoardApprovals
     */
    public function setNrBoardApprovals($nrBoardApprovals)
    {
        $this->nrBoardApprovals = $nrBoardApprovals;
    }

    /**
     * @return mixed
     */
    public function getBoardApprover1()
    {
        return $this->boardApprover1;
    }

    /**
     * @param mixed $boardApprover1
     */
    public function setBoardApprover1($boardApprover1)
    {
        $this->boardApprover1 = $boardApprover1;
    }

    /**
     * @return mixed
     */
    public function getBoardApprover2()
    {
        return $this->boardApprover2;
    }

    /**
     * @param mixed $boardApprover2
     */
    public function setBoardApprover2($boardApprover2)
    {
        $this->boardApprover2 = $boardApprover2;
    }

    /**
     * @return mixed
     */
    public function getBoardApprover3()
    {
        return $this->boardApprover3;
    }

    /**
     * @param mixed $boardApprover3
     */
    public function setBoardApprover3($boardApprover3)
    {
        $this->boardApprover3 = $boardApprover3;
    }

    /**
     * @return mixed
     */
    public function getBoardApprovalStatus1()
    {
        return $this->boardApprovalStatus1;
    }

    /**
     * @param mixed $boardApprovalStatus1
     */
    public function setBoardApprovalStatus1($boardApprovalStatus1)
    {
        $this->boardApprovalStatus1 = $boardApprovalStatus1;
    }

    /**
     * @return mixed
     */
    public function getBoardApprovalStatus2()
    {
        return $this->boardApprovalStatus2;
    }

    /**
     * @param mixed $boardApprovalStatus2
     */
    public function setBoardApprovalStatus2($boardApprovalStatus2)
    {
        $this->boardApprovalStatus2 = $boardApprovalStatus2;
    }

    /**
     * @return mixed
     */
    public function getBoardApprovalStatus3()
    {
        return $this->boardApprovalStatus3;
    }

    /**
     * @param mixed $boardApprovalStatus3
     */
    public function setBoardApprovalStatus3($boardApprovalStatus3)
    {
        $this->boardApprovalStatus3 = $boardApprovalStatus3;
    }

    /**
     * @return mixed
     */
    public function getApproval1At()
    {
        return $this->approval1At;
    }

    /**
     * @param mixed $approval1At
     */
    public function setApproval1At($approval1At)
    {
        $this->approval1At = $approval1At;
    }

    /**
     * @return mixed
     */
    public function getApproval2At()
    {
        return $this->approval2At;
    }

    /**
     * @param mixed $approval2At
     */
    public function setApproval2At($approval2At)
    {
        $this->approval2At = $approval2At;
    }

    /**
     * @return mixed
     */
    public function getApproval3At()
    {
        return $this->approval3At;
    }

    /**
     * @param mixed $approval3At
     */
    public function setApproval3At($approval3At)
    {
        $this->approval3At = $approval3At;
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

    /**
     * @return mixed
     */
    public function getProcessedBy()
    {
        return $this->processedBy;
    }

    /**
     * @param mixed $processedBy
     */
    public function setProcessedBy($processedBy)
    {
        $this->processedBy = $processedBy;
    }

    /**
     * @return mixed
     */
    public function getProcessedAt()
    {
        return $this->processedAt;
    }

    /**
     * @param mixed $processedAt
     */
    public function setProcessedAt($processedAt)
    {
        $this->processedAt = $processedAt;
    }

    /**
     * @return mixed
     */
    public function getAccountCreated()
    {
        return $this->accountCreated;
    }

    /**
     * @param mixed $accountCreated
     */
    public function setAccountCreated($accountCreated)
    {
        $this->accountCreated = $accountCreated;
    }

    /**
     * @return mixed
     */
    public function getProfileDocuments()
    {
        return $this->profileDocuments;
    }

    /**
     * @param mixed $profileDocuments
     */
    public function setProfileDocuments($profileDocuments)
    {
        $this->profileDocuments = $profileDocuments;
    }

    /**
     * @return mixed
     */
    public function getProfileSamples()
    {
        return $this->profileSamples;
    }



    /**
     * @return mixed
     */
    public function getIdemnifyFirstName()
    {
        return $this->idemnifyFirstName;
    }

    /**
     * @param mixed $idemnifyFirstName
     */
    public function setIdemnifyFirstName($idemnifyFirstName)
    {
        $this->idemnifyFirstName = $idemnifyFirstName;
    }

    /**
     * @return mixed
     */
    public function getIdemnifyLastName()
    {
        return $this->idemnifyLastName;
    }

    /**
     * @param mixed $idemnifyLastName
     */
    public function setIdemnifyLastName($idemnifyLastName)
    {
        $this->idemnifyLastName = $idemnifyLastName;
    }

    /**
     * @return mixed
     */
    public function getIdemnifyAt()
    {
        return $this->idemnifyAt;
    }

    /**
     * @param mixed $idemnifyAt
     */
    public function setIdemnifyAt($idemnifyAt)
    {
        $this->idemnifyAt = $idemnifyAt;
    }


}