<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 6/12/2017
 * Time: 3:16 PM
 ********************************************************************************/

namespace AppBundle\Repository;

use AppBundle\Entity\CorporateProfile;
use AppBundle\Entity\Profile;
use Doctrine\ORM\EntityRepository;

class CorporateRepository extends EntityRepository
{
    /**
     * @return CorporateProfile[]
     */
    public function findAllOpenProfilesOrderByDate(){

        return $this->createQueryBuilder('profile')
            ->orderBy('profile.createdAt','DESC')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',true)
            ->andWhere('profile.profileStatus = :isApproved')
            ->setParameter(':isApproved','Pending')
            ->getQuery()
            ->execute();
    }
    /**
     * @return CorporateProfile[]
     */
    public function findAllMembershipApprovedProfilesOrderByDate(){

        return $this->createQueryBuilder('profile')
            ->orderBy('profile.createdAt','DESC')
            ->andWhere('profile.isMembershipApproved = :isMembershipApproved')
            ->setParameter('isMembershipApproved',true)
            ->andWhere('profile.isBoardApproved is NULL')
            ->getQuery()
            ->execute();
    }
    /**
     * @return CorporateProfile[]
     */
    public function findAllBoardApprovedProfilesOrderByDate(){

        return $this->createQueryBuilder('profile')
            ->orderBy('profile.createdAt','DESC')
            ->andWhere('profile.isBoardApproved = :isBoardApproved')
            ->setParameter(':isBoardApproved',true)
            ->getQuery()
            ->execute();
    }
    /**
     * @return CorporateProfile[]
     */
    public function findAllApprovedProfilesOrderByDate(){

        return $this->createQueryBuilder('profile')
            ->orderBy('profile.createdAt','DESC')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',true)
            ->andWhere('profile.isBoardApproved = :isBoardApproved')
            ->setParameter(':isBoardApproved',true)
            ->getQuery()
            ->execute();
    }
    /**
     * @return CorporateProfile[]
     */
    public function findAllRejectedProfilesOrderByDate(){

        return $this->createQueryBuilder('profile')
            ->orderBy('profile.createdAt','DESC')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',true)
            ->andWhere('profile.profileStatus = :isApproved')
            ->setParameter(':isApproved',"Rejected")
            ->getQuery()
            ->execute();
    }
    /**
     * @return CorporateProfile[]
     */
    public function findAllUnpaidProfilesOrderByDate(){

        return $this->createQueryBuilder('profile')
            ->orderBy('profile.createdAt','DESC')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',false)
            ->getQuery()
            ->execute();
    }
    public function findNrProfiles(){
        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
    public function findNrApproved(){
        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->andWhere('profile.profileStatus = :isApproved')
            ->setParameter(':isApproved','Approved')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
    public function findNrRejected(){
        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->andWhere('profile.profileStatus = :isApproved')
            ->setParameter(':isApproved','Rejected')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
    public function findNrUnderReview(){
        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',true)
            ->andWhere('profile.profileStatus = :isApproved')
            ->setParameter(':isApproved','Pending')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
    public function findNrUnpaidProfiles(){
        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',false)
            ->andWhere('profile.profileStatus = :isApproved')
            ->setParameter(':isApproved','')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
    public function findNrNew(){
        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->andWhere('profile.createdAt > :createdAt')
            ->setParameter('createdAt', new \DateTime('-5 days'))
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
    public function findNrBoardApprovedProfiles(){

        $nrProfiles= $this->createQueryBuilder('profile')
            ->select('count(profile.id)')
            ->andWhere('profile.isPaid = :isPaid')
            ->setParameter(':isPaid',true)
            ->andWhere('profile.isBoardApproved = :isBoardApproved')
            ->setParameter(':isBoardApproved',true)
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrProfiles){
            return $nrProfiles;
        }else{
            return 0;
        }
    }
}