<?php

namespace English\TermBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TermType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term', 'text', array('attr' => array('class' => 'form-control')))
            ->add('termName', 'text', array('attr' => array('class' => 'form-control')))
            ->add('type', 'choice', array('attr' => array('class' => ''),'choices' => array('2' => 'Default', '1' => 'Display', '0' => 'Archive'), 'required'  => false, 'expanded' => true, 'multiple' => false,))
        ;
    }

    public function getName()
    {
        return 'english_termbundle_termtype';
    }
}
