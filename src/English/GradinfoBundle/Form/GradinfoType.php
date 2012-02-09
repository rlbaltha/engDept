<?php

namespace English\GradinfoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GradinfoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('status')
        ;
    }

    public function getName()
    {
        return 'english_gradinfobundle_gradinfotype';
    }
}
