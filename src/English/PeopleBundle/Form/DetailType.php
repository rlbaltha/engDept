<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startdate', 'choice', array('label'=> 'Start Date ','choices'   => array('F15' => 'F15','F16' => 'F16', 'F17' => 'F17'),'required'  => false,  'expanded' => false,))
            ->add('enddate', 'choice', array('label'=> 'Completion Date','choices'   => array('S15' => 'S15','S16' => 'S16', 'S17' => 'S17'),'required'  => false,  'expanded' => false,))
            ->add('accomplishments', 'ckeditor', array('required' => false,'label'=> 'Accomplishments','config_name' => 'editor_simple',))
            ->add('placement', 'ckeditor', array('required' => false,'label'=> 'Placement','config_name' => 'editor_simple',))
            ->add('courseloadF', 'choice', array('label'=> 'Course load Fall','choices'   => array('0' => '0','1' => '1', '2' => '2', '3' => '3', '4' => '4'),'required'  => false,  'expanded' => true,))
            ->add('courseloadS', 'choice', array('label'=> 'Course load Spring','choices'   => array('0' => '0','1' => '1', '2' => '2', '3' => '3', '4' => '4'),'required'  => false,  'expanded' => true,))
            ->add('homeDept', 'text', array('attr' => array('class' => 'form-control')))
            ->add('appCompleted', 'choice', array('label'=> 'Completed apprenticeship','choices'   => array('yes' => 'yes', 'no' => 'no'),'required'  => true, 'expanded' => true,))
            ->add('homeDept', 'choice', array('label'=> 'Home department','choices'   => array('Eng' => 'Eng', 'Ling' => 'Ling'),'required'  => true,  'expanded' => true,))
            ->add('notes', 'ckeditor', array('required' => false,'label'=> 'Notes','config_name' => 'editor_simple',))        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'English\PeopleBundle\Entity\Detail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'english_peoplebundle_detail';
    }
}
