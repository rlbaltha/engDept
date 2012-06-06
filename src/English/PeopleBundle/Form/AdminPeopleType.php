<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminPeopleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username','hidden')
            ->add('lastName')
            ->add('firstName')
            ->add('title')
            ->add('rank', 'text', array('attr' => array('class' => 'width640')))
            ->add('area','entity', array('class'=>'EnglishAreasBundle:Area', 'property'=>'area','expanded'=>true,'multiple'=>true, ))
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
            ->add('position','entity', array('class'=>'EnglishPositionBundle:Position', 'property'=>'position','expanded'=>true,'multiple'=>true, ))    
            ->add('active', 'hidden')
            ->add('status', 'hidden')
            ->add('gradinfo','entity', array('class'=>'EnglishGradinfoBundle:Gradinfo', 'property'=>'status','expanded'=>true,'multiple'=>false, ))    
        ;
    }

    public function getName()
    {
        return 'english_peoplebundle_peopletype';
    }
}
