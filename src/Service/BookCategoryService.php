<?php

namespace App\Service;

use App\Entity\BookCategory;
use App\Entity\DataSearch;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class BookCategoryService 
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
     * Récupérer une instance de recherche sur les catégories de livres
     * 
     * @param   int     $id     Filtre sur identifiant de la catégorie
     * 
     * @return DataSearch       Instance avec les différents critères de recherche
     */
    public function getBookCategorySearch($id=null) {
        $search = new DataSearch();
        
        $search->set(DataSearch::BOOK_CATEGORY, $id);
        
        return $search;
    }

    /**
     * Récupérer les catégories de livres correspondant aux critères de sélection
     * 
     * @param   DataSearch      $search     Critères de sélection
     * 
     * @return array    Tableau de catégories
     */
    public function getBookCategories(DataSearch $search=null) {
        return $this->em->getRepository(BookCategory::class)->getBookCategory($search);
    }


}