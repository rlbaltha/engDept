<?php

namespace English\SpotlightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SpotlightType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('photoUrl')
            ->add('title')
            ->add('description')
            ->add('type')
        ;
    }

    public function getName()
    {
        return 'english_spotlightbundle_spotlighttype';
    }
}
