<?php

namespace English\DescriptionsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('callNumber','hidden')
            ->add('term','hidden')
            ->add('course','hidden')
            ->add('instructorName','hidden')
            ->add('description')
            ->add('assignments')
            ->add('requirements')
            ->add('grading')
            ->add('attendance')
            ->add('material')
            ->add('makeup')
            ->add('url', 'text', array('attr' => array('class' => 'width640')))
            ->add('topics', 'choice', array('choices' => array ('t' => 'Yes','f' => 'No'), 
                'expanded' => true, 'required' => true,))
            ->add('topicsTitle', 'text', array('attr' => array('class' => 'width640')))    
        ;
    }

    public function getName()
    {
        return 'english_descriptionsbundle_descriptiontype';
    }
}
