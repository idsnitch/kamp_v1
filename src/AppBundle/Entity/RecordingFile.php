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
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="recording_file")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class RecordingFile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @Vich\UploadableField(mapping="recording_mp3",fileNameProperty="documentFileName",size="documentFileSize")
     *
     * @var File $documentFile
     * @Assert\NotBlank()
     */
    private $documentFile;
    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $documentFileName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $documentFileSize;
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
     * @return File|null
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $documentFile
     * @return RecordingFile
     */
    public function setDocumentFile(File $documentFile=null)
    {
        $this->documentFile = $documentFile;

        if ($documentFile){
            //Change at least one field to force the event listeners to fire
            $this->updatedAt= new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocumentFileName()
    {
        return $this->documentFileName;
    }

    /**
     * @param string $documentFileName
     * @return RecordingFile
     */
    public function setDocumentFileName($documentFileName)
    {
        $this->documentFileName = $documentFileName;
        return $this;
    }

    /**
     * @return integer|null
     */
    public function getDocumentFileSize()
    {
        return $this->documentFileSize;
    }

    /**
     * @param integer $documentFileSize
     *
     * @return RecordingFile
     */
    public function setDocumentFileSize($documentFileSize)
    {
        $this->documentFileSize = $documentFileSize;

        return $this;
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


}