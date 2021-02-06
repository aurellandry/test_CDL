<?php

namespace App\Repository;

use App\Entity\DataSearch;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class DataSearchRepository extends EntityRepository
{  

    /**
     * Vérifier qu'un alias existe dans la requête
     * La table associée à un alias n'est pas toujours chargée dans la requête principale
     * Notamment en cas d'utilisation de critères de recherche
     *  
     * @param QueryBuilder  $qb         Instance de QueryBuilder
     * @param string        $alias      Nom de l'alias
     * 
     * @return boolean
     */
    public function aliasExists(QueryBuilder $qb, $alias) {
        return in_array($alias, $qb->getAllAliases());
    }

    /**
     * Ajouter les critères de recherche sur les catégories de livres dans la requête
     * 
     * @param QueryBuilder  $qb         Instance de QueryBuilder
     * @param DataSearch    $search     Critères de sélection 
     */
    public function addSearchCriteriaBookCategory(QueryBuilder $qb, DataSearch $search){
        if(!$this->aliasExists($qb, 'category')) {
            return;
        }

        // Identifiant
        $id = $search->get(DataSearch::BOOK_CATEGORY);
        if($id) {
            $qb->andWhere('category.id IN (:id)')->setParameter('id', $id);
        }
    }

    /**
     * Ajouter les critères de recherche sur les auteurs dans la requête
     * 
     * @param QueryBuilder  $qb         Instance de QueryBuilder
     * @param DataSearch    $search     Critères de sélection 
     */
    public function addSearchCriteriaAuthor(QueryBuilder $qb, DataSearch $search){
        if(!$this->aliasExists($qb, 'author')) {
            return;
        }

        // Identifiant
        $id = $search->get(DataSearch::AUTHOR);
        if($id) {
            $qb->andWhere('author.id = :id')->setParameter('id', $id);
        }
    }
}