<?php

namespace English\GradcomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GradcomType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('gid')
            ->add('fid')
            ->add('frole')
            ->add('status')
        ;
    }

    public function getName()
    {
        return 'english_gradcombundle_gradcomtype';
    }
}
