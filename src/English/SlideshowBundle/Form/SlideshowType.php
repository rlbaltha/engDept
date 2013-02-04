<?php

namespace English\SlideshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SlideshowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
