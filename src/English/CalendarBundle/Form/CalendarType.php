<?php

namespace English\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'form-control')))
            ->add('date', 'date', array('widget' => 'single_text', 'attr' => array('class' => 'form-control'), 'format' => 'MM/dd/yyyy'))
            ->add('time', 'time', array('widget' => 'single_text', 'attr' => array('name' => 'timepicker','class' => 'form-control')))
            ->add('description', 'ckeditor', array('config_name' => 'editor_simple',))
            ->add('username', 'hidden')
        ;
    }

    public function getName()
    {
        return 'english_calendarbundle_calendartype';
    }
}
