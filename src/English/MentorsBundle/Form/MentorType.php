<?php

namespace English\MentorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MentorType extends AbstractType
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
        return 'english_mentorsbundle_mentortype';
    }
}
