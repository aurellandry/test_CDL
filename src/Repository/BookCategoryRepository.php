<?php

namespace App\Repository;

use App\Entity\BookCategory;
use App\Entity\DataSearch;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookCategory[]    findAll()
 * @method BookCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookCategoryRepository extends DataSearchRepository
{
    /**
     * Obtenir la liste des catégories de livres correspondant aux critères de recherche
     * 
     * @param   DataSearch  $search     Critères de sélection
     * 
     * @return  QueryBuilder
     */
    public function getBookCategoryQb(DataSearch $search=null){
        if(!$search){
            $search = new DataSearch();
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('category')
           ->from('App\Entity\BookCategory', 'category');

        $this->addSearchCriteriaBookCategory($qb, $search);

        return $qb;
    }

    /**
     * Récupération de toutes les catégories de livres
     * 
     * @param   DataSearch      $search         Critères de sélection
     * 
     * @return array
     */
    public function getBookCategory(DataSearch $search=null) {

        $qb = $this->getBookCategoryQb($search);

        try {
            return $qb->getQuery()->execute();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
