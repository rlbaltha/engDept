<?php

namespace English\SlideshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SlideshowType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('photoUrl')
            ->add('title')
            ->add('type')
        ;
    }

    public function getName()
    {
        return 'english_slideshowbundle_slideshowtype';
    }
}
