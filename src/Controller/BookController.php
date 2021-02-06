<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\DataSort;
use App\Entity\DataSearch;
use App\Form\BookType;

use Symfony\Component\HttpFoundation\Request;

class BookController extends MasterController
{
    /**
     * Affichage de la page recensant les livres
     * 
     * @param   Request     $request    Requête HTTP
     * 
     * @return  Response
     */
    public function index(Request $request){
        // Récupérer tous les livres
        $search     = $this->getBookService()->getBookSearch();
        // On instancie le formulaire de recherche
        $form       = $this->getSearchForm($request, $search);

        // Critères de tri
        $sort_key   = $sort_order   = null;
        $sort       = $this->getSort($request, $sort_key, $sort_order, 
                                    array(DataSort::DATE => 'DESC'));

        $books      = $this->getBookService()->getBooks($search);

        $parameters = array(
            'form'      => $form->createView(),
            'sort_key'  => $sort_key,
            'sort_order'=> $sort_order,
            'books'     =>  $books
        );

        return $this->render('Book/index.html.twig', $parameters);
    }

    /**
     * Ajout / Édition d'un livre
     * 
     * @param   Request     $request    Requête HTTP
     * @param   int         $id         Identifiant
     * 
     * @return  Response
     */
    public function editBook(Request $request, int $id=null){
        if($id) {
            $mode       = 'update';
            $search     = $this->getBookService()->getBookSearch($id);
            $book       = $this->getBookService()->getBooks($search) ? $this->getBookService()->getBooks($search)[0] : new Book();
        }
        else {
            $mode       = 'new';
            $book       = new Book();
        }

        $form       = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveBook($book, $mode);

            return $this->redirectFormToRoute('book_edit', array('id' => $book->getId()));
        }

        $parameters = array(
            'form'      => $form->createView(),
            'book'      => $book,
            'mode'      => $mode
        );

        return $this->render('Book/edit.html.twig', $parameters);
    }

    /**
     * Suppression d'un livre
     * 
     * @param   Request     $request    Requête HTTP
     * @param   int         $id         Identifiant
     * 
     * @return  Response
     */
    public function deleteBook(Request $request, int $id=null){
        if($id){
            $mode       = 'delete';
            $search     = $this->getBookService()->getBookSearch($id);
            $book       = $this->getBookService()->getBooks($search) ? $this->getBookService()->getBooks($search)[0] : new Book();

            $this->saveBook($book, $mode);
        }

        return $this->redirectFormToRoute('book');
    }

    /**
     * Compléter le livre avec des informations avant enregistrement
     * 
     * @param   Book        $book
     * @param   string      $mode 
     * 
     * @return Book
     */
    private function completeBookBeforeSave(Book $book, string $mode) {
        if($mode == 'new'){
            $book->setCreatedAt(new \DateTime());
            $book->setCreatedBy($this->getUser());
        }
        $book->setUpdatedAt(new \DateTime());
        $book->setUpdatedBy($this->getUser());

        return $book;
    }

    /**
     * Enregistrer un livre en base de données
     * 
     * @param   Book        $book
     * @param   string      $mode 
     */
    private function saveBook(Book $book, string $mode){
        $book = $this->completeBookBeforeSave($book, $mode);
        
        $em = $this->getDoctrine()->getManager();
        switch($mode){
            case 'delete':
                $em->remove($book);
                break;
            default:
                $em->persist($book);
        }
        
        $em->flush();
        $this->addFlash('success', 'Enregistré avec succès');
    }
}