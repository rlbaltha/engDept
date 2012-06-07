<?php

namespace English\DawgspeakBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DefType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('term')
            ->add('pos1')
            ->add('def1')
            ->add('pos2')
            ->add('def2')
            ->add('pos3')
            ->add('def3')
            ->add('image')
            ->add('ref')
            ->add('etymology')
        ;
    }

    public function getName()
    {
        return 'english_dawgspeakbundle_deftype';
    }
}
