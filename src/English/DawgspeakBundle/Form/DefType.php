<?php

namespace English\DawgspeakBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term', 'text', array('attr' => array('class' => 'width300')))
            ->add('pos1', 'text', array('attr' => array('class' => 'width300')))
            ->add('def1')
            ->add('pos2', 'text', array('attr' => array('class' => 'width300')))
            ->add('def2')
            ->add('pos3', 'text', array('attr' => array('class' => 'width300')))
            ->add('def3')
            ->add('image', 'text', array('attr' => array('class' => 'width300')))
            ->add('ref', 'text', array('attr' => array('class' => 'width300')))
            ->add('etymology')
        ;
    }

    public function getName()
    {
        return 'english_dawgspeakbundle_deftype';
    }
}
