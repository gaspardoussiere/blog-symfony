<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdressType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('steet', TextType::class, [
                'label' => 'adresse'
            ])
            ->add('zip', TextType::class, [
                'label' => 'Code postal'
            ]);
        if ($options['with_country']) {
            $builder->add('country', ChoiceType::class, [
                'label' => "Pays",
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Italie' => 'IT'
                ]
            ]);
        }
    }
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'with_country' => true
        ]);
    }
}
