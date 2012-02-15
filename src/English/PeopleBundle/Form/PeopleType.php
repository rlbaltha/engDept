<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
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
            ->add('position', 'choice', array( 'choices'   => array('Faculty' => 'Faculty','Adminstration' => 'Adminstration','Faculty and Administration' => 'Faculty and Administration',
                'Graduate Student' => 'Graduate Student','Instructor' => 'Instructor', 'Retired' => 'Retired'), 'multiple' => false, 'expanded' => true,))
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
