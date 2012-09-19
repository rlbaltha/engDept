<?php

namespace English\MajorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class MajorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {  
        $builder
            ->add('name')
            ->add('email', 'text', array('attr' => array('class' => 'width300')))
            ->add('advisor', 'entity', array('class' => 'EnglishAdvisorsBundle:Advisor','property'=>'name', 'preferred_choices' => array('19'),'query_builder' => 
                 function(\English\AdvisorsBundle\Entity\AdvisorRepository $er) {
                 return $er->createQueryBuilder('a')
                 ->orderBy('a.name', 'ASC');
                 }))
            ->add('mentor', 'entity', array('class' => 'EnglishMentorsBundle:Mentor','property'=>'name', 'preferred_choices' => array('1'),'query_builder' => 
                 function(\English\MentorsBundle\Entity\MentorRepository $er) {
                 return $er->createQueryBuilder('m')
                 ->orderBy('m.name', 'ASC');
                 }))     
            ->add('firstMajor')
            ->add('secondMajor')
            ->add('aoe', 'text', array('attr' => array('class' => 'width300')))
            ->add('can')
            ->add('minor')   
            ->add('honors')
            ->add('notes') 
            ->add('hours', 'hidden') 
            ->add('gpa', 'hidden')     
            ->add('status','choice', array('choices' => array('0'=>'Active','1'=> 'Graduated','2'=> 'Inactive'),'expanded'=>true,))
            ->add('checkedin','choice', array('choices' => array('0'=>'No','1'=> 'Yes'),'expanded'=>true,));    
        ;
    }

    public function getName()
    {
        return 'english_majorsbundle_majortype';
    }
}
