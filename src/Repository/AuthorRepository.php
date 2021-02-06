<?php

namespace App\Repository;

use App\Entity\Author;
use App\Entity\DataSearch;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends DataSearchRepository
{
    /**
     * Obtenir la liste des auteurs correspondant aux critères de recherche
     * 
     * @param   DataSearch  $search     Critères de sélection
     * 
     * @return  QueryBuilder
     */
    public function getAuthorQb(DataSearch $search=null){
        if(!$search){
            $search = new DataSearch();
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('author')
           ->from('App\Entity\Author', 'author');

        $this->addSearchCriteriaAuthor($qb, $search);

        return $qb;
    }

    /**
     * Récupération de toutes les auteurs
     * 
     * @param   DataSearch      $search         Critères de sélection
     * 
     * @return array
     */
    public function getAuthor(DataSearch $search=null) {

        $qb = $this->getAuthorQb($search);

        try {
            return $qb->getQuery()->execute();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
