<?php

namespace English\SpotlightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SpotlightType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('photoUrl', 'text', array('attr' => array('class' => 'width640')))
            ->add('title', 'text', array('attr' => array('class' => 'width300')))
            ->add('description')
            ->add('sortOrder', 'choice', array('choices'   => array(1, 2), 'multiple'  => false, 'expanded'  => true,))    
            ->add('type', 'hidden')
        ;
    }

    public function getName()
    {
        return 'english_spotlightbundle_spotlighttype';
    }
}
