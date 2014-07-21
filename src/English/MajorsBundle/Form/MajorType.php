<?php

namespace English\MajorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class MajorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
        $builder
            ->add('name')
            ->add('email', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('advisor', 'entity', array('class' => 'EnglishAdvisorsBundle:Advisor','property'=>'name', 'query_builder' => 
                 function(\English\AdvisorsBundle\Entity\AdvisorRepository $er) {
                 return $er->createQueryBuilder('a')
                 ->orderBy('a.name', 'ASC');
                 }))
            ->add('mentor', 'entity', array('class' => 'EnglishMentorsBundle:Mentor','property'=>'name', 'query_builder' => 
                 function(\English\MentorsBundle\Entity\MentorRepository $er) {
                 return $er->createQueryBuilder('m')
                 ->orderBy('m.name', 'ASC');
                 }))
            ->add('firstMajor', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('secondMajor', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('aoe', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('email', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('can', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('minor', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('honors', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('notes', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('hours', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('gpa', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('status','choice', array('choices' => array('0'=>'Active','1'=> 'Graduated','2'=> 'Inactive'),'expanded'=>true,))
            ->add('checkedin','choice', array('choices' => array('0'=>'No','1'=> 'Yes'),'expanded'=>true,));    
        ;
    }

    public function getName()
    {
        return 'english_majorsbundle_majortype';
    }
}
