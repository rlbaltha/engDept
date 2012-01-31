<?php

namespace English\AreasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AreaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('area')
        ;
    }

    public function getName()
    {
        return 'english_areasbundle_areatype';
    }
}
