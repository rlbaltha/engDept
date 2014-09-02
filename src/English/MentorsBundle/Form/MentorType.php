<?php

namespace English\MentorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MentorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('class' => 'form-control')))
            ->add('username', 'text', array('attr' => array('class' => 'form-control')))
        ;
    }

    public function getName()
    {
        return 'english_mentorsbundle_mentortype';
    }
}
