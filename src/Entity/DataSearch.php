<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\ParameterBag;

class DataSearch extends ParameterBag
{
    /**
     * Clés de recherche
     * Et valeurs prédéfinies
     */
    const WHATEVER          = 'whatever';

    // Clés sur l'entité Author
    const AUTHOR            = 'author';

    // Clés sur l'entité Book
    const BOOK_ID           = 'book_id';
    const BOOK_TITLE        = 'book_title';

    // Clés sur l'entité BookCategory
    const BOOK_CATEGORY     = 'book_category';

    // Clés sur la date
    const DATE              = 'date';
    
    /**
     * Pour récupérer les valeurs dans un formulaire
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function __get($key) {
        return $this->get($key);
    }

    /**
     * Vérifie qu'au moins une clé a été définie
     * 
     * @return boolean
     */
    public function isNotEmpty(){
        for($i = 0; $i < count($this->keys()); $i++){
            if($this->get($this->keys()[$i])){
                return true;
            }
        }

        return false;
    }
}
