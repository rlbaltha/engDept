<?php

namespace English\AdvisorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvisorType extends AbstractType
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
        return 'english_advisorsbundle_advisortype';
    }
}
