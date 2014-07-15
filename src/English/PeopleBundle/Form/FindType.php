<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FindType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName')
        ;
    }

    public function getName()
    {
        return 'english_peoplebundle_peopletype';
    }
}
