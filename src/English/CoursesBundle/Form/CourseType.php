<?php

namespace English\CoursesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('courseName')
            ->add('instructorName')
            ->add('callNumber')
            ->add('room')
            ->add('days')
            ->add('term')
            ->add('time')
            ->add('building')
            ->add('callNumber2')
            ->add('username')
            ->add('period')
            ->add('title')
            ->add('area')
            ->add('may')
        ;
    }

    public function getName()
    {
        return 'english_coursesbundle_coursetype';
    }
}
