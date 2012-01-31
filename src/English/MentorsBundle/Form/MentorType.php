<?php

namespace English\MentorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MentorType extends AbstractType
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
        return 'english_mentorsbundle_mentortype';
    }
}
