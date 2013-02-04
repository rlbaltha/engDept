<?php

namespace English\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'width300')))
            ->add('date', 'date', array('widget' => 'single_text','format' => 'MM/dd/yyyy')) 
            ->add('time', 'time', array('widget' => 'single_text', 'attr' => array('name' => 'timepicker'))) 
            ->add('description')
            ->add('username', 'hidden')   
        ;
    }

    public function getName()
    {
        return 'english_calendarbundle_calendartype';
    }
}
