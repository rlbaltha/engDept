<?php

namespace English\CoursesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('courseName', 'text', array('attr' => array('class' => 'form-control')))
            ->add('instructorName', 'text', array('attr' => array('class' => 'form-control')))
            ->add('callNumber', 'text', array('attr' => array('class' => 'form-control')))
            ->add('building', 'text', array('attr' => array('class' => 'form-control')))
            ->add('room', 'text', array('attr' => array('class' => 'form-control')))
            ->add('days', 'text', array('attr' => array('class' => 'form-control')))
            ->add('time', 'text', array('attr' => array('class' => 'form-control')))
            ->add('may')
            ->add('notes', 'ckeditor', array('config_name' => 'editor_simple',))

        ;
    }

    public function getName()
    {
        return 'english_coursesbundle_coursetype';
    }
}
