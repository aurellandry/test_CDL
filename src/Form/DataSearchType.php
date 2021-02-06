<?php

namespace App\Form;

use App\Entity\DataSearch;
use App\Service\BookCategoryService;
use App\Service\AuthorService;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class DataSearchType extends AbstractType
{
    /**
     * Instance du service en charge des catégories de livres
     * 
     * @var BookCategoryService 
     */
    private $bookCategoryService;

    /**
     * Instance du service en charge des auteurs
     * 
     * @var AuthorService 
     */
    private $authorService;
    
    /**
     * Constructeur
     */
    public function __construct(BookCategoryService $bookCategoryService, AuthorService $authorService) {
        $this->bookCategoryService  = $bookCategoryService;
        $this->authorService        = $authorService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        // On spécifie la méthode GET pour que la recherche et le tri puissent fonctionner ensemble
        $builder->setMethod('GET');
        
        // Les champs sont affichés en fonction des critères de recherche paramétrés dans l'objet DataSearch
        // Pour éviter des requêtes SQL inutiles quand le champ de recherche n'est pas affiché dans le formulaire
        // Pour éviter l'envoi de la donnée en GET quand le champ de recherche n'est pas affiché dans le formulaire
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $search = $event->getData();
            $form   = $event->getForm();

            // Recherche sur champs multiples (saisie libre)
            /*if($this->addField(DataSearch::WHATEVER, $search)) {
                $form->add(DataSearch::WHATEVER, TextType::class, array(
                    'label' => 'Vos critères de recherche'
                ));
            }*/

            // Nom du livre
            if($this->addField(DataSearch::BOOK_TITLE, $search)) {
                $form->add(DataSearch::BOOK_TITLE, TextType::class, array(
                    'label' => 'Nom du livre'
                ));
            }

            // Date du livre
            if($this->addField(DataSearch::DATE, $search)) {
                $form->add(DataSearch::DATE, DateType::class, array(
                    'label' => 'Date du livre (à partir de)',
                    'widget' => 'single_text',
                ));
            }

            // Catégories de livres (liste déroulante)
            if($this->addField(DataSearch::BOOK_CATEGORY, $search)) {
                $form->add(DataSearch::BOOK_CATEGORY, ChoiceType::class, array(
                    'label'         => 'Catégorie du livre',
                    'label_attr'    => array(
                        'class' => 'checkbox-inline'
                    ),
                    'choices'       => $this->buildBookCategoryChoices(),
                    'multiple'  => true,
                    'expanded'  => true,
                    'empty_data'    => null,
                    'required'      => false
                ));
            }

            // Auteurs (liste déroulante)
            if($this->addField(DataSearch::AUTHOR, $search)) {
                $form->add(DataSearch::AUTHOR, ChoiceType::class, array(
                    'label'         => 'Auteurs',
                    'choices'       => $this->buildAuthorChoices(),
                    'empty_data'    => null,
                    'required'      => false
                ));
            }

        });
    }

    public function configureOptions(OptionsResolver $resolver) {
        
        // Ne pas renseigner de classe pour ce formulaire !
        // Il s'agit d'un formulaire générique pour afficher des critères de recherche
        $resolver->setDefaults(array('csrf_protection' => false,));
        
    }
    
    /**
     * Préfixe utilisé pour nommer les éléments du formulaire
     * Toute modification doit être reportée dans les templates, codes JS et CSS
     * 
     * @return string
     */
    public function getBlockPrefix() {
        return 'ds';
    }
    
    /**
     * Valider qu'un champ doit être ajouté dans le formulaire
     * 
     * @param string    $id         Identifiant du champ 
     * @param array     $data       Données caractérisant la recherche 
     * 
     * @return boolean
     */
    private function addField($id, $data) {
        return array_key_exists($id, $data);
    }
    
    /**
     * Liste des catégories de livres
     * 
     * @return array
     */
    private function buildBookCategoryChoices() {
        $choices    = [];
        $categories = $this->bookCategoryService->getBookCategories();

        foreach ($categories as $cat) {
            $choices[$cat->getName()] = $cat->getId();
        }

        return $choices;
    }
    
    /**
     * Liste des auteurs
     * 
     * @return array
     */
    private function buildAuthorChoices() {
        $choices    = [];
        $authors    = $this->authorService->getAuthors();

        foreach ($authors as $author) {
            $choices[$author->getName()] = $author->getId();
        }

        return $choices;
    }


}