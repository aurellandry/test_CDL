<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DataSearch;
use App\Entity\DataSort;
use App\Form\DataSearchType;
use App\Service\BookCategoryService;
use App\Service\BookService;
use App\Service\AuthorService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MasterController extends AbstractController
{
    /**
     * BookCategoryService
     */
    private $bookCategoryService;

    /**
     * BookService
     */
    private $bookService;

    /**
     * AuthorService
     */
    private $authorService;


    /**
     * Constructeur
     */
    public function __construct(BookCategoryService $bookCategoryService, 
                                BookService $bookService,
                                AuthorService $authorService)
    {
        $this->bookCategoryService      = $bookCategoryService;
        $this->bookService              = $bookService;
        $this->authorService            = $authorService;
    }

    /**
     * Récupérer un repository
     * 
     * @param string    $name      Nom du repository
     * 
     * @return EntityRepository
     */
    public function getRepository($name) {
        return $this->getDoctrine()->getManager()->getRepository($name);
    }

    /**
     * Récupérer une instance du service BookCategoryService
     * 
     * @return  BookCategoryService
     */
    public function getBookCategoryService(){
        return $this->bookCategoryService;
    }

    /**
     * Récupérer une instance du service BookService
     * 
     * @return  BookService
     */
    public function getBookService(){
        return $this->bookService;
    }

    /**
     * Récupérer une instance du service AuthorService
     * 
     * @return  AuthorService
     */
    public function getAuthorService(){
        return $this->authorService;
    }

    /**
     * Instancier le formulaire de recherche à partir des paramètres présents dans la requête HTTP
     * Et modifier en conséquence la recherche
     * 
     * @param Request       $request    Instance de la requête HTTP
     * @param DataSearch    $search     Critères de recherche initiaux
     * 
     * @return Form
     */
    public function getSearchForm(Request $request, DataSearch $search) {
        // Il est possible que le formulaire de recherche n'aie pas été traité dans le cas d'un POST d'un autre formulaire
        // Car le formulaire de recherche intercepte la méthode GET
        // Néanmoins si les critères de recherche sont dans l'URL, il faut les intercepter
        if($request->isMethod('POST')) {
            $arr = $request->get('ds');
            foreach ($search->keys() as $key) {
                if(array_key_exists($key, $arr)) {
                    $v = DataSearch::cast($key, $arr[$key]);
                    $search->set($key, $v);
                }
            }
        }
        
        $form = $this->createForm(DataSearchType::class, $search->all());
        $form->handleRequest($request);
        
        $search->add($form->getData());
        
        return $form;
    }

    /**
     * Returns a RedirectResponse to the given route with the given parameters.
     *
     * @param string $route      The name of the route
     * @param array  $parameters An array of parameters
     * @param int    $status     The status code to use for the Response
     *
     * @return RedirectResponse
     */
    protected function redirectFormToRoute($route, array $parameters = array(), $status = 302) {
        return $this->redirectToRoute($route, $parameters, $status);
    }

    /**
     * Enregistrer un utilisateur en base de données
     * 
     * @param   User        $user
     */
    private function saveUser(User $user){
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * Récupérer le paramètre de tri dans la requête HTTP
     * Et ajouter un éventuel critère de tri
     * 
     * @param Request   $request        Instance de la requête HTTP
     * @param string    $sort_key       Clé de tri principale
     * @param string    $sort_order     Ordre de tri pour la clé principale
     * @param array     $default        Tris par défaut
     * 
     * @return DataSort
     */
    public function getSort(Request $request, &$sort_key, &$sort_order, array $default=array()) {
        $dataSort  = new DataSort();
        $sort_key   = $request->query->get('sort');
        $orders     = array('ASC', 'DESC');
        
        // Tri dans la requête HTTP
        if($sort_key) {
            $sort_order  = strtoupper($request->query->get('order', 'ASC'));
        
            if(!in_array($sort_order, $orders)) {
                $sort_order = null;
            }
            
            $dataSort->set($sort_key, $sort_order);
        }
        
        // Tri par défaut appliqué si aucun tri détecté dans requête HTTP
        if(!$sort_key && count($default)>0) {
            foreach($default as $sort=>$order) {
                // On n'écrase pas le critère s'il a été redéfini dans la requête HTTP
                if(!$dataSort->has($sort)) {
                    $order = strtoupper($order);
                    if(!in_array($order, $orders)) {
                        $order = null;
                    }
            
                    $dataSort->set($sort, $order);
                    if(!$sort_key) {
                        $sort_key   = $sort;
                        $sort_order = $order;
                    }
                }
            }
        }
        
        return $dataSort;
    }
    
}
