<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => "Prénom de l'élève"
            ])
            ->add('lastName', TextType::class, [
                'label' => "Nom de famille de l'élève"
            ])
            ->add('classe', EntityType::class, [
                'label' => "Classe de l'élève",
                'class' => Classe::class,
                'choice_label' => "name",
                'expanded' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
