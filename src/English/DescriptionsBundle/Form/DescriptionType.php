<?php

namespace English\DescriptionsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('callNumber','hidden')
            ->add('term','hidden')
            ->add('course','hidden')
            ->add('instructorName','hidden')
            ->add('description', 'ckeditor', array('config_name' => 'editor_default','label'=>'Description '))
            ->add('assignments', 'ckeditor', array('config_name' => 'editor_simple','label'=>'Principal course assignments (such as required reading papers, other activities, and the week of the course in which these assignments are expected to be completed and submitted) '))
            ->add('requirements', 'ckeditor', array('config_name' => 'editor_simple','label'=>'Specific course requirements for grading purposes (e.g., written and oral tests and reports, research papers, performances or other similar requirements, participation requirements, if any) '))
            ->add('grading', 'ckeditor', array('config_name' => 'editor_simple','label'=>'Grading Policy (How the final grade will be determined with respect to weights or course points assigned to various course requirements.) '))
            ->add('attendance', 'ckeditor', array('config_name' => 'editor_simple','label'=>'Information regarding attendance policy (If there are specific requirements for attendance, these should be stated; if attendance is to be weighed for the final grade, the syllabus should state what the weight or course points will be.) '))
            ->add('material', 'ckeditor', array('config_name' => 'editor_simple','label'=>'Required course material, including texts'))
            ->add('makeup', 'ckeditor', array('config_name' => 'editor_simple','label'=>'Policy for make-up of assignments '))
            ->add('url', 'text', array('label'=>'Course website URL ','attr' => array('class' => 'form-control')))
            ->add('topics', 'choice', array('choices' => array ('t' => 'Yes','f' => 'No'), 
                'expanded' => true, 'required' => true, 'label'=>'Is this a topics course/seminar?'))
            ->add('topicsTitle', 'text', array('label'=>'Topics/seminar title ','attr' => array('class' => 'form-control')))
        ;
    }

    public function getName()
    {
        return 'english_descriptionsbundle_descriptiontype';
    }
}
