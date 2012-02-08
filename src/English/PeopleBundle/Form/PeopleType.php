<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('title')
            ->add('rank', 'text', array('attr' => array('class' => 'width640')))
            ->add('area', 'text', array('attr' => array('class' => 'width640')))
            ->add('vitaUrl', 'text', array('attr' => array('class' => 'width640')))
            ->add('homepageUrl', 'text', array('attr' => array('class' => 'width640')))
            ->add('email', 'text', array('attr' => array('class' => 'width640')))
            ->add('officeHours')
            ->add('bio')
            ->add('photoUrl', 'text', array('attr' => array('class' => 'width640')))    
            ->add('officeNumber')
            ->add('officePhone')
            ->add('address', 'text', array('attr' => array('class' => 'width640')))
            ->add('address2', 'text', array('attr' => array('class' => 'width640')))    
            ->add('cellPhone')
            ->add('spouse')
            ->add('homePhone')    
            ->add('position', 'text', array('attr' => array('class' => 'width640')))
            ->add('username', 'hidden') 
            ->add('active', 'hidden')
            ->add('status', 'hidden')    
        ;
    }

    public function getName()
    {
        return 'english_peoplebundle_peopletype';
    }
}
