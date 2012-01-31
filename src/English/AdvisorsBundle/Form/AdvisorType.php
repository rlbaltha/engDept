<?php

namespace English\AdvisorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdvisorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('username')
        ;
    }

    public function getName()
    {
        return 'english_advisorsbundle_advisortype';
    }
}
