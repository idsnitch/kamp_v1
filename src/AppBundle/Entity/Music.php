<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 7/4/2017
 * Time: 12:51 PM
 ********************************************************************************/

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="music")
 * @ORM\HasLifecycleCallbacks
 */
class Music
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
    private $albumTitle;
    /**
     * @ORM\Column(type="string")
     */
    private $recordingStudio;
    /**
     * @ORM\Column(type="string")
     */
    private $sampleType;
    /**
     * @ORM\Column(type="date")
     */
    private $dateOfProduction;
    /**
     * @ORM\Column(type="string")
     */
    private $countryOfProduction="KE";
    /**
     * @ORM\Column(type="string")
     */
    private $countryOfRecording="KE";
    /**
     * @ORM\Column(type="string")
     */
    private $format;
    /**
     * @ORM\Column(type="string")
     */
    private $mainArtist;
    /**
     * @Assert\Type("AppBundle\Entity\DocumentFile")
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DocumentFile",cascade={"persist"})
     */
    private $documentFile;
    /**
     * @Assert\Type("AppBundle\Entity\RecordingFile")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RecordingFile",cascade={"persist"})
     */
    private $recordingFile;
    /**
     * @Assert\Type("AppBundle\Entity\DocumentFile")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RecordingFile",cascade={"persist"})
     */
    private $letterOfAdministration;
    /**
     * @Assert\Type("AppBundle\Entity\DocumentFile")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RecordingFile",cascade={"persist"})
     */
    private $deathCertificate;
    /**
     * @Assert\Type("AppBundle\Entity\DocumentFile")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RecordingFile",cascade={"persist"})
     */
    private $artistContract;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile",inversedBy="profileDocuments")
     */
    private $whichProfile;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CorporateProfile",inversedBy="corporateProfileDocuments")
     */
    private $whichCorporateProfile;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        // we set up "created"+"modified"
        $this->setCreatedAt(new \DateTime());
        if ($this->getUpdatedAt() == null) {
            $this->setUpdatedAt(new \DateTime());
        }

    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setUpdatedAt(new \DateTime());
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
    public function getWhichProfile()
    {
        return $this->whichProfile;
    }

    /**
     * @param mixed $whichProfile
     */
    public function setWhichProfile($whichProfile)
    {
        $this->whichProfile = $whichProfile;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getWhichCorporateProfile()
    {
        return $this->whichCorporateProfile;
    }

    /**
     * @param mixed $whichCorporateProfile
     */
    public function setWhichCorporateProfile($whichCorporateProfile)
    {
        $this->whichCorporateProfile = $whichCorporateProfile;
    }

    /**
     * @return mixed
     */
    public function getAlbumTitle()
    {
        return $this->albumTitle;
    }

    /**
     * @param mixed $albumTitle
     */
    public function setAlbumTitle($albumTitle)
    {
        $this->albumTitle = $albumTitle;
    }

    /**
     * @return mixed
     */
    public function getDateOfProduction()
    {
        return $this->dateOfProduction;
    }

    /**
     * @param mixed $dateOfproduction
     */
    public function setDateOfProduction($dateOfProduction)
    {
        $this->dateOfProduction = $dateOfProduction;
    }

    /**
     * @return mixed
     */
    public function getRecordingStudio()
    {
        return $this->recordingStudio;
    }

    /**
     * @param mixed $recordingStudio
     */
    public function setRecordingStudio($recordingStudio)
    {
        $this->recordingStudio = $recordingStudio;
    }

    /**
     * @return mixed
     */
    public function getSampleType()
    {
        return $this->sampleType;
    }

    /**
     * @param mixed $sampleType
     */
    public function setSampleType($sampleType)
    {
        $this->sampleType = $sampleType;
    }

    /**
     * @return mixed
     */
    public function getCountryOfRecording()
    {
        return $this->countryOfRecording;
    }

    /**
     * @param mixed $countryOfRecording
     */
    public function setCountryOfRecording($countryOfRecording)
    {
        $this->countryOfRecording = $countryOfRecording;
    }

    /**
     * @return mixed
     */
    public function getCountryOfProduction()
    {
        return $this->countryOfProduction;
    }

    /**
     * @param mixed $countryOfProduction
     */
    public function setCountryOfProduction($countryOfProduction)
    {
        $this->countryOfProduction = $countryOfProduction;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return mixed
     */
    public function getMainArtist()
    {
        return $this->mainArtist;
    }

    /**
     * @param mixed $mainArtist
     */
    public function setMainArtist($mainArtist)
    {
        $this->mainArtist = $mainArtist;
    }

    /**
     * @return mixed
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @param mixed $documentFile
     */
    public function setDocumentFile($documentFile)
    {
        $this->documentFile = $documentFile;
    }

    /**
     * @return mixed
     */
    public function getRecordingFile()
    {
        return $this->recordingFile;
    }

    /**
     * @param mixed $recordingFile
     */
    public function setRecordingFile($recordingFile)
    {
        $this->recordingFile = $recordingFile;
    }

    /**
     * @return mixed
     */
    public function getLetterOfAdministration()
    {
        return $this->letterOfAdministration;
    }

    /**
     * @param mixed $letterOfAdministration
     */
    public function setLetterOfAdministration($letterOfAdministration)
    {
        $this->letterOfAdministration = $letterOfAdministration;
    }

    /**
     * @return mixed
     */
    public function getDeathCertificate()
    {
        return $this->deathCertificate;
    }

    /**
     * @param mixed $deathCertificate
     */
    public function setDeathCertificate($deathCertificate)
    {
        $this->deathCertificate = $deathCertificate;
    }

    /**
     * @return mixed
     */
    public function getArtistContract()
    {
        return $this->artistContract;
    }

    /**
     * @param mixed $artistContract
     */
    public function setArtistContract($artistContract)
    {
        $this->artistContract = $artistContract;
    }


}