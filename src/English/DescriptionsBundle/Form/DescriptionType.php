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
            ->add('description', 'textarea', array('label'=>' '))
            ->add('assignments', 'textarea', array('label'=>' '))
            ->add('requirements', 'textarea', array('label'=>' '))
            ->add('grading', 'textarea', array('label'=>' '))
            ->add('attendance', 'textarea', array('label'=>' '))
            ->add('material', 'textarea', array('label'=>' '))
            ->add('makeup', 'textarea', array('label'=>' '))
            ->add('url', 'text', array('label'=>' '), array('attr' => array('class' => 'width640')))
            ->add('topics', 'choice', array('choices' => array ('t' => 'Yes','f' => 'No'), 
                'expanded' => true, 'required' => true,))
            ->add('topicsTitle', 'text', array('label'=>' '), array('attr' => array('class' => 'width640')))    
        ;
    }

    public function getName()
    {
        return 'english_descriptionsbundle_descriptiontype';
    }
}
