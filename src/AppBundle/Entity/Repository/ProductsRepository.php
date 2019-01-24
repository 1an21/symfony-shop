<?php
namespace AppBundle\Entity\Repository;
class ProductsRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchQuery()
    {
        return $this->_em->getRepository('AppBundle:Products')->createQueryBuilder('p');
    }

    public function deleteOneImageQuery($file)
    {
        $query = $this->_em->createQuery(
            "
            DELETE 
            FROM AppBundle:Files p where p.file =:file
            
            "
        );
        $query->setParameter('file', $file);
        return $query;

    }
}