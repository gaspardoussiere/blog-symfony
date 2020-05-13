<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Category;
use App\Entity\EventCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => "titre de l'evenement",
                'attr' => [
                    'placeholder' => "Entrez le titre de l'evenement"
                ]
            ])
            ->add('place', TextType::class, [
                'required' => true,
                'label' => "Lieu de l'evenement",
                'attr' => [
                    'placeholder' => "Entrez le lieu de l'evenement"
                ]
            ])
            ->add('time')
            ->add('image', UrlType::class, [
                'label' => "Saisissez l'URL de l'immage",
                'attr' => [
                    'placeholder' => "Adresse URL"
                ],
                'help' => "Choisissez une image jolie"
            ])
            ->add('description', TextareaType::class, [
                'label' => "Contenu de l'event",
                'attr' => [
                    'placeholder' => "Faites envie avec une belle histoire"
                ],
                'help' => "Soignez la mise en forme"
            ])
            ->add('eventCategory', EntityType::class, [
                'label' => "Catégorie de l'evenement",
                'class' => EventCategory::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
