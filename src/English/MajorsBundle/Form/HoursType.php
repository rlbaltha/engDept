<?php

namespace English\MajorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class HoursType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('hours')
            ->add('gpa')    
        ;
    }

    public function getName()
    {
        return 'english_majorsbundle_hourstype';
    }
}