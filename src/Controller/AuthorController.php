<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\DataSearch;
use App\Form\AuthorType;

use Symfony\Component\HttpFoundation\Request;

class AuthorController extends MasterController
{
    /**
     * Affichage de la page recensant les auteurs
     * 
     * @param   Request     $request    Requête HTTP
     * 
     * @return  Response
     */
    public function index(Request $request){
        // Récupérer tous les auteurs
        $search     = $this->getAuthorService()->getAuthorSearch();
        // On instancie le formulaire de recherche
        $form       = $this->getSearchForm($request, $search);

        $authors    = $this->getAuthorService()->getAuthors($search);

        $parameters = array(
            'form'      => $form->createView(),
            'authors'   => $authors
        );

        return $this->render('Author/index.html.twig', $parameters);
    }

    /**
     * Ajout / Édition d'un auteur
     * 
     * @param   Request     $request    Requête HTTP
     * @param   int         $ref        Référence
     * 
     * @return  Response
     */
    public function editAuthor(Request $request, int $id=null){
        if($id) {
            $mode       = 'update';
            $search     = $this->getAuthorService()->getAuthorSearch($id);
            $author     = $this->getAuthorService()->getAuthors($search)[0];
        }
        else {
            $mode       = 'new';
            $author     = new Author();
        }

        $form       = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveAuthor($author, $mode);

            return $this->redirectFormToRoute('author_edit', array('id' => $author->getId()));
        }

        $parameters = array(
            'form'      => $form->createView(),
            'author'    => $author,
            'mode'      => $mode
        );

        return $this->render('Author/edit.html.twig', $parameters);
    }

    /**
     * Compléter l'auteur avec des informations avant enregistrement
     * 
     * @param   Author     $author
     * @param   string     $mode 
     * 
     * @return Author
     */
    private function completeAuthorBeforeSave(Author $author, string $mode) {
        if($mode == 'new'){
            $author->setCreatedAt(new \DateTime());
            $author->setCreatedBy($this->getUser());
        }
        $author->setUpdatedAt(new \DateTime());
        $author->setUpdatedBy($this->getUser());

        return $author;
    }

    /**
     * Enregistrer un auteur en base de données
     * 
     * @param   Author     $author
     * @param   string     $mode 
     */
    private function saveAuthor(Author $author, string $mode){
        $category = $this->completeAuthorBeforeSave($author, $mode);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();
        $this->addFlash('success', 'Enregistré avec succès');
    }
}