<?php

namespace English\DescriptionsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('callNumber')
            ->add('term')
            ->add('course')
            ->add('instructorName')
            ->add('description')
            ->add('assignments')
            ->add('requirements')
            ->add('grading')
            ->add('attendance')
            ->add('material')
            ->add('makeup')
            ->add('url')
            ->add('topicsTitle')
            ->add('topics')
        ;
    }

    public function getName()
    {
        return 'english_descriptionsbundle_descriptiontype';
    }
}
