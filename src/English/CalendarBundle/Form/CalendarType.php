<?php

namespace English\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'width300')))
            ->add('date') 
            ->add('time', 'time', array('widget' => 'single_text')) 
            ->add('description')
            ->add('username', 'hidden')   
        ;
    }

    public function getName()
    {
        return 'english_calendarbundle_calendartype';
    }
}
