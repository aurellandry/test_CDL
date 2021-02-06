<?php

namespace App\Controller;

use App\Entity\BookCategory;
use App\Entity\DataSearch;
use App\Form\BookCategoryType;

use Symfony\Component\HttpFoundation\Request;

class BookCategoryController extends MasterController
{
    /**
     * Affichage de la page recensant les catégories de livres
     * 
     * @param   Request     $request    Requête HTTP
     * 
     * @return  Response
     */
    public function index(Request $request){
        // Récupérer toutes les catégories de livre
        $search     = $this->getBookCategoryService()->getBookCategorySearch();
        // On instancie le formulaire de recherche
        $form       = $this->getSearchForm($request, $search);

        $categories = $this->getBookCategoryService()->getBookCategories($search);

        $parameters = array(
            'form'          => $form->createView(),
            'categories'    => $categories
        );

        return $this->render('BookCategory/index.html.twig', $parameters);
    }

    /**
     * Ajout / Édition d'une catégorie de livre
     * 
     * @param   Request     $request    Requête HTTP
     * @param   int         $id         Identifiant
     * 
     * @return  Response
     */
    public function editCategory(Request $request, int $id=null){
        if($id) {
            $mode       = 'update';
            $search     = $this->getBookCategoryService()->getBookCategorySearch($id);
            $category   = $this->getBookCategoryService()->getBookCategories($search)[0];
        }
        else {
            $mode       = 'new';
            $category   = new BookCategory();
        }

        $form       = $this->createForm(BookCategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveBookCategory($category, $mode);

            return $this->redirectFormToRoute('book_category_edit', array('id' => $category->getId()));
        }

        $parameters = array(
            'form'  => $form->createView(),
            'cat'   => $category,
            'mode'  => $mode
        );

        return $this->render('BookCategory/edit.html.twig', $parameters);
    }

    /**
     * Compléter la catégorie avec des informations avant enregistrement
     * 
     * @param   BookCategory     $category
     * @param   string              $mode 
     * 
     * @return BookCategory
     */
    private function completeBookCategoryBeforeSave(BookCategory $category, string $mode) {
        if($mode == 'new'){
            $category->setCreatedAt(new \DateTime());
            $category->setCreatedBy($this->getUser());
        }
        $category->setUpdatedAt(new \DateTime());
        $category->setUpdatedBy($this->getUser());

        return $category;
    }

    /**
     * Enregistrer une catégorie en base de données
     * 
     * @param   BookCategory     $category
     * @param   string              $mode 
     */
    private function saveBookCategory(BookCategory $category, string $mode){
        $category = $this->completeBookCategoryBeforeSave($category, $mode);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        $this->addFlash('success', 'Enregistré avec succès');
    }
}