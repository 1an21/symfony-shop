<?php
namespace AppBundle\Entity\Repository;
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCustomersQuery()
    {
        $query = $this->_em->createQuery(
            "
            SELECT c
            FROM AppBundle:User c
            WHERE c.role = 'ROLE_CUSTOMER'
            "
        );
        return $query;
    }
}