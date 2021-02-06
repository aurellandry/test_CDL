<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\DataSearch;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends DataSearchRepository
{
    /**
     * Obtenir la liste des livres correspondant aux critères de recherche
     * 
     * @param   DataSearch  $search     Critères de sélection
     * 
     * @return  QueryBuilder
     */
    public function getBookQb(DataSearch $search=null){
        if(!$search){
            $search = new DataSearch();
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('book, category, author')
           ->from('App\Entity\Book', 'book')
           ->leftJoin('book.author', 'author')
           ->leftJoin('book.category', 'category');

        $this->addSearchCriteriaBook($qb, $search);
        $this->addSearchCriteriaBookCategory($qb, $search);
        $this->addSearchCriteriaAuthor($qb, $search);

        return $qb;
    }

    /**
     * Ajouter les critères de recherche sur les livres dans la requête
     * 
     * @param QueryBuilder  $qb         Instance de QueryBuilder
     * @param DataSearch    $search     Critères de sélection 
     */
    public function addSearchCriteriaBook(QueryBuilder $qb, DataSearch $search){
        if(!$this->aliasExists($qb, 'book')) {
            return;
        }

        // Identifiant
        $id = $search->get(DataSearch::BOOK_ID);
        if($id) {
            $qb->andWhere('book.id=:id')->setParameter('id', $id);
        }

        // Nom
        $title = $search->get(DataSearch::BOOK_TITLE);
        if($title) {
            $title = "%".$title."%";
            $qb->andWhere('book.title LIKE :title')->setParameter('title', $title);
        }

        // Date
        $date = $search->get(DataSearch::DATE);
        if($date) {
            // Seule l'année est prise en compte
            //$date = \DateTime($date)->format('Y');
            $qb->andWhere('YEAR(book.date)>=YEAR(:date)')->setParameter('date', $date);
        }
    }

    /**
     * Récupération de toutes les livres
     * 
     * @param   DataSearch      $search         Critères de sélection
     * 
     * @return array
     */
    public function getBook(DataSearch $search=null) {

        $qb = $this->getBookQb($search);

        try {
            return $qb->getQuery()->execute();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
