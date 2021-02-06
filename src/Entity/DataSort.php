<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\ParameterBag;

class DataSort extends ParameterBag
{
    /**
     * Critères de recherche portant sur l'auteur
     */
    const AUTHOR        = 'author';

    /**
     * Critères de recherche portant sur le livre
     */
    const BOOK_TITLE    = 'book_title';
    const BOOK_CATEGORY = 'book_category';

    /**
     * Critères de recherche portant sur la date
     */
    const DATE          = 'date';
}
