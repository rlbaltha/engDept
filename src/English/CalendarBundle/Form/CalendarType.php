<?php

namespace English\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('time')
            ->add('title')
            ->add('description')
            ->add('username')
        ;
    }

    public function getName()
    {
        return 'english_calendarbundle_calendartype';
    }
}
