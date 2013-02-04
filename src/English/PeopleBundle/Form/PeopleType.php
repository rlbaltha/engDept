<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','hidden')
            ->add('lastName')
            ->add('firstName')
            ->add('title')
            ->add('rank', 'text', array('attr' => array('class' => 'width640'),'required' => false,))
            ->add('area','entity', array('class'=>'EnglishAreasBundle:Area', 'property'=>'area','expanded'=>true,'multiple'=>true, 'required' => false,))
            ->add('vitaUrl', 'text', array('attr' => array('class' => 'width640'),'required' => false,))
            ->add('homepageUrl', 'text', array('attr' => array('class' => 'width640'),'required' => false,))
            ->add('email', 'text', array('attr' => array('class' => 'width640')))
            ->add('officeHours')
            ->add('bio')
            ->add('photoUrl', 'text', array('attr' => array('class' => 'width640',),'required' => false,))    
            ->add('officeNumber')
            ->add('officePhone')
            ->add('address', 'text', array('attr' => array('class' => 'width640'),'required' => false,))
            ->add('address2', 'text', array('attr' => array('class' => 'width640'),'required' => false,))    
            ->add('cellPhone')
            ->add('spouse')
            ->add('homePhone')    
            ->add('position','entity', array('class'=>'EnglishPositionBundle:Position', 'property'=>'position','expanded'=>true,'multiple'=>true,'required' => true, )) 
            ->add('active', 'hidden')
            ->add('status', 'hidden')
            ->add('gradinfo','entity', array('class'=>'EnglishGradinfoBundle:Gradinfo', 'property'=>'status','expanded'=>true,'multiple'=>false,'required' => true, ))     
        ;
    }

    public function getName()
    {
        return 'english_peoplebundle_peopletype';
    }
}
