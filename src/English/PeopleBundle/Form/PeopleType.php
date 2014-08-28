<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label'=> 'UGA MyId**','attr' => array('class' => 'form-control')))
            ->add('email', 'text', array('label'=> 'UGA Email**','attr' => array('class' => 'form-control')))
            ->add('lastName', 'text', array('label'=> 'Last Name**','attr' => array('class' => 'form-control')))
            ->add('firstName', 'text', array('label'=> 'First Name**','attr' => array('class' => 'form-control')))
            ->add('title', 'ckeditor', array('required' => false,'label'=> 'Title','config_name' => 'editor_simple',))
            ->add('rank', 'text',  array('required' => false,'attr' => array('class' => 'form-control')))
            ->add('position','entity', array('label'=> 'Position**','class'=>'EnglishPositionBundle:Position', 'property'=>'position','expanded'=>true,'multiple'=>true,'required' => true, ))
            ->add('area','entity', array('class'=>'EnglishAreasBundle:Area', 'property'=>'area','expanded'=>true,'multiple'=>true, 'required' => false,))
            ->add('officeHours', 'ckeditor', array('required' => false,'label'=> 'Office Hours','config_name' => 'editor_simple',))
            ->add('bio', 'ckeditor', array('required' => false,'label'=> 'Bio','config_name' => 'editor_default',))
            ->add('photoUrl', 'text', array('required' => false,'label'=> 'Photo URL','attr' => array('class' => 'form-control')))
            ->add('officeNumber', 'text', array('required' => false,'label'=> 'Office','attr' => array('class' => 'form-control')))
            ->add('officePhone', 'text', array('required' => false,'label'=> 'Office Phone','attr' => array('class' => 'form-control')))
            ->add('vitaUrl', 'text', array('required' => false,'label'=> 'Vita URL','attr' => array('class' => 'form-control')))
            ->add('homepageUrl', 'text', array('required' => false,'label'=> 'Homepage URL','attr' => array('class' => 'form-control')))


            ->add('active', 'hidden')
            ->add('status', 'hidden')
            ->add('gradinfo','entity', array('label'=> 'Graduate Student Status**','class'=>'EnglishGradinfoBundle:Gradinfo', 'property'=>'status','expanded'=>true,'multiple'=>false,'required' => true, ))
            ->add('address', 'text', array('required' => false,'label'=> 'Address (dept. use only)', 'attr' => array('class' => 'form-control')))
            ->add('cellPhone', 'text', array('required' => false,'label'=> 'Cell Phone (dept. use only)','attr' => array('class' => 'form-control')))
            ->add('spouse', 'text', array('required' => false,'label'=> 'Spouse (dept. use only)','attr' => array('class' => 'form-control')))
            ->add('homePhone', 'text', array('required' => false,'label'=> 'Home Phone (dept. use only)','attr' => array('class' => 'form-control')))

       ;
    }

    public function getName()
    {
        return 'english_peoplebundle_peopletype';
    }
}
