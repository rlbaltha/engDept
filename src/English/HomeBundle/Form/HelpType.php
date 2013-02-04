<?php

namespace English\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HelpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('teaser')
            ->add('body')
            ->add('sortorder')
        ;
    }

    public function getName()
    {
        return 'english_homebundle_helptype';
    }
}
