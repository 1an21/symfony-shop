<?php
namespace AppBundle\Entity\Repository;
class ProductsRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchQuery()
    {
        return $this->_em->getRepository('AppBundle:Products')->createQueryBuilder('p');
    }
}