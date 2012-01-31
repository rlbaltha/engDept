<?php

namespace English\TermBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TermType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('term')
            ->add('termName')
            ->add('type')
        ;
    }

    public function getName()
    {
        return 'english_termbundle_termtype';
    }
}
