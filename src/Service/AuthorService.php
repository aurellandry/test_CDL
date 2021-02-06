<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\DataSearch;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class AuthorService 
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
     * Récupérer une instance de recherche sur les auteurs
     * 
     * @param   int     $id     Filtre sur l'identifiant de l'auteur
     * 
     * @return  DataSearch
     */
    public function getAuthorSearch($id=null) {
        $search = new DataSearch();
        
        $search->set(DataSearch::AUTHOR, $id);
        
        return $search;
    }

    /**
     * Récupérer les auteurs correspondant aux critères de sélection
     * 
     * @param   DataSearch      $search     Critères de sélection
     * 
     * @return array    Tableau de commandes
     */
    public function getAuthors(DataSearch $search=null) {
        return $this->em->getRepository(Author::class)->getAuthor($search);
    }

}