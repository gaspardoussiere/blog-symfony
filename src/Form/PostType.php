<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\Type\TagType;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\TagsTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\CategoryTransformer;
use App\Form\Type\AdressType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{

    // protected CategoryRepository $categoryRepository;
    // protected CategoryTransformer $categoryTransformer;
    // public function __construct(CategoryRepository $categoryRepository, CategoryTransformer $categoryTransformer)
    // {
    //     $this->categoryRepository = $categoryRepository;
    //     $this->categoryTransformer = $categoryTransformer;
    // }
    protected TagsTransformer $tagsTransformer;

    public function __construct(TagsTransformer $tagsTransformer)
    {
        $this->tagsTransformer = $tagsTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => "Titre de l'article",
                'attr' => [
                    'class' => 'toto',
                    'placeholder' => "Entrez le titre de l'article"
                ],
                'help' => "Soyez percuttant et concis"
            ])
            // ->add('adress', AdressType::class, [
            //     'mapped' => false,
            //     'with_country' => false
            // ])
            ->add('content', TextareaType::class, [
                'label' => "Contenu de l'article",
                'attr' => [
                    'placeholder' => "Faites envie avec une belle histoire"
                ],
                'help' => "Soignez la mise en forme"
            ])
            ->add('image', UrlType::class, [
                'label' => "Saisissez l'URL de l'immage",
                'attr' => [
                    'placeholder' => "Adresse URL"
                ],
                'help' => "Choisissez une image jolie"
            ])
            // ->add('tags', EntityType::class, [
            //     'label' => "Etiquettes",
            //     'class' => Tag::class,
            //     'choice_label' => 'title',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'by_reference' => false
            // ])
            ->add('tags', EntityType::class, [
                'label' => 'Etiquettes',
                'class' => Tag::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
            ->add('category', EntityType::class, [
                'label' => "Catégorie de l'article",
                'class' => Category::class,
                // 'choice_label' => 'title'
                'choice_label' => function (Category $c) {
                    return sprintf('%s - %s', $c->getId(), $c->getTitle());
                }
            ]);
        // $builder->get('category')->addModelTransformer($this->categoryTransformer);
        // $builder->get('tags')->addModelTransformer($this->tagsTransformer);
    }

    // protected function getCategories(): array
    // {
    //     // Récupérer les données dans la base
    //     $categories = $this->categoryRepository->findAll();
    //     // Créer un tableau associatif
    //     $options = [];
    //     foreach ($categories as $category) {
    //         $options[$category->getTitle()] = $category->getId();
    //     }
    //     // Le retourner
    //     return $options;
    // }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
