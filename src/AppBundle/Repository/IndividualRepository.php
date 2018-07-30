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
use AppBundle\Entity\individual;
use AppBundle\Entity\Onboard;
use Doctrine\ORM\EntityRepository;

class IndividualRepository extends EntityRepository
{
    public function findNrOnboards(){
        $nrIndividuals= $this->createQueryBuilder('individual')
            ->select('count(individual.id)')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrIndividuals){
            return $nrIndividuals;
        }else{
            return 0;
        }
    }
    /**
     * @return Individual[]
     */
    public function findAllUsers(){

        return $this->createQueryBuilder('user')
            ->orderBy('individual.companyName','DESC')
            ->getQuery()
            ->execute();
    }
}