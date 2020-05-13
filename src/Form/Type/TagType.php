<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\TagsTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TagType extends AbstractType
{
    protected TagsTransformer $tagstransformer;
    public function __construct(TagsTransformer $tagstransformer)
    {
        $this->tagstransformer = $tagstransformer;
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->tagstransformer);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
