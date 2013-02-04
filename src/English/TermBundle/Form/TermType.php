<?php

namespace English\TermBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TermType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term')
            ->add('termName')
            ->add('type', 'choice', array('choices' => array('2' => 'Default', '1' => 'Display', '0' => 'Archive'), 'required'  => false, 'expanded' => true, 'multiple' => false,))
        ;
    }

    public function getName()
    {
        return 'english_termbundle_termtype';
    }
}
