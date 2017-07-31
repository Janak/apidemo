<?php
// src/AppBundle/Repository/ProductRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    
    public function findAllUsers()
    {
        return $this->getEntityManager()
        ->createQuery(
            'SELECT u.username FROM AppBundle:User u ORDER BY u.username ASC'
            )
            ->getResult();
    }
}