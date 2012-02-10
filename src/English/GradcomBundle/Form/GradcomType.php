<?php

namespace English\GradcomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GradcomType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('gid','hidden')
            ->add('fid','hidden')
            ->add('frole', 'choice', array('choices' => array('1' => 'Member', '2' => 'Chair'),'required'  => true,'label'  => 'Committee Role'))
            ->add('status', 'hidden')             
        ;
    }

    public function getName()
    {
        return 'english_gradcombundle_gradcomtype';
    }
}
