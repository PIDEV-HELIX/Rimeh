<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ShopBundle\Entity\Mail;
use Doctrine\ORM\Query;
/**
 * MailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MailRepository extends EntityRepository
{
  public function findEntitiesByString($str){
      return $this->getEntityManager()
          ->createQuery(
              'SELECT p
                FROM ShopBundle:Mail p
                WHERE p.subject LIKE :str'
          )
          ->setParameter('str', '%'.$str.'%')
          ->getResult();
  }

}
