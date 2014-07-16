<?php

namespace English\SpotlightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SpotlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photoUrl', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('title', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('description', 'textarea', array('attr' => array('class' => 'textarea form-control')))
            ->add('sortOrder', 'choice', array('choices'   => array(1, 2, 3), 'multiple'  => false, 'expanded'  => true,'attr' => array('class' => 'form-control'),))
            ->add('type', 'hidden')
        ;
    }

    public function getName()
    {
        return 'english_spotlightbundle_spotlighttype';
    }
}
