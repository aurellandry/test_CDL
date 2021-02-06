<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookCategory;

use App\Service\AuthorService;
use App\Service\BookCategoryService;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookType extends AbstractType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Nom
        $builder->add('title', TextType::class, [
            'label' => 'Nom du livre',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]
        ]);

        // Date
        $builder->add('date', DateType::class, [
            'label' => 'Date',
            'widget' => 'single_text',
        ]);

        // Zone de commentaire
        $builder->add('comments', TextareaType::class, [
            'label' => 'Commentaires',
            'attr'  => ['rows' => '5']
        ]);

        // Catégories
        $book_category_options = array(
            'label'         => 'Catégorie',
            'class'         => BookCategory::class,
            'choices'       => $this->buildBookCategoryChoices(),
            'choice_label'  => 'name',
            'required'      => true
        );
        $builder->add('category', EntityType::class, $book_category_options);

        // Auteurs
        $author_options = array(
            'label'         => 'Auteur',
            'class'         => Author::class,
            'choices'       => $this->buildAuthorChoices(),
            'choice_label'  => 'name',
            'empty_data'    => null,
            'required'      => false
        );
        $builder->add('author', EntityType::class, $author_options);

        // Bouton Envoyer
        $builder->add('submit', SubmitType::class, array(
            'label' => 'Enregistrer'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }

    /**
     * Liste des catégories de livres
     * 
     * @return array
     */
    private function buildBookCategoryChoices() {
        return $this->bookCategoryService->getBookCategories();
    }

    /**
     * Liste des auteurs
     * 
     * @return array
     */
    private function buildAuthorChoices() {
        return $this->authorService->getAuthors();
    }

}
