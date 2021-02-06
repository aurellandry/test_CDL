<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\DataSearch;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class BookService 
{
    /**
     * Logger
     * 
     * @var Psr\Log\LoggerInterface; 
     */
    protected $logger;
    
    /**
     * Gestionnaire d'entité
     * 
     * @var EntityManager 
     */
    protected $em;
    
    /**
     * Constructeur
     * 
     * @param Logger                $logger
     * @param TranslatorInterface   $translator
     * @param EntityManager         $em
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em) {
        $this->logger       = $logger;
        $this->em           = $em;
    }

    /**
     * Récupérer une instance de recherche sur les catégories de produits
     * 
     * @param   int             $id         Filtre sur identifiant
     * @param   string          $title      Filtre sur Nom du livre
     * @param   string          $date       Filtre sur date du livre
     * @param   int             $cat        Filtre sur catégorie du livre
     * @param   int             $author     Filtre sur auteur du livre
     * 
     * @return  DataSearch          Instance avec les différents critères de recherche
     */
    public function getBookSearch($id=null, $title=null, $date=null, $cat=null, $author=null) {
        $search = new DataSearch();
        
        $search->set(DataSearch::BOOK_ID, $id);
        $search->set(DataSearch::BOOK_TITLE, $title);
        $search->set(DataSearch::DATE, $date);
        $search->set(DataSearch::BOOK_CATEGORY, $cat);
        $search->set(DataSearch::AUTHOR, $author);
        
        return $search;
    }

    /**
     * Récupérer les livres correspondant aux critères de sélection
     * 
     * @param   DataSearch      $search     Critères de sélection
     * 
     * @return array    Tableau de produits
     */
    public function getBooks(DataSearch $search=null) {
        return $this->em->getRepository(Book::class)->getBook($search);
    }

}