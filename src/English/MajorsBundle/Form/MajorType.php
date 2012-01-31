<?php

namespace English\MajorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MajorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('advisor')
            ->add('mentorUserName')
            ->add('firstMajor')
            ->add('secondMajor')
            ->add('aoe')
            ->add('can')
            ->add('minor')
            ->add('status')
            ->add('notes')
            ->add('honors')
            ->add('advisorId')
            ->add('mentorId')
        ;
    }

    public function getName()
    {
        return 'english_majorsbundle_majortype';
    }
}
