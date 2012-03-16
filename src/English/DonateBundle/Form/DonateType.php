<?php

namespace English\DonateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DonateType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fund')
            ->add('link')
            ->add('image')    
            ->add('description')
            ->add('type','entity', array('class'=>'EnglishDonateBundle:Type', 'property'=>'name', ))    
        ;
    }

    public function getName()
    {
        return 'english_donatebundle_donatetype';
    }
}
