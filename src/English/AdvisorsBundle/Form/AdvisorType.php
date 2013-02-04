<?php

namespace English\AdvisorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvisorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
