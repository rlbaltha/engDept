<?php

namespace English\SlideshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SlideshowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text', array('attr' => array('class' => 'text form-control'),))
            ->add('photoUrl','text', array('attr' => array('class' => 'text form-control'),))
            ->add('description', 'ckeditor', array('required' => false,'label'=> 'Title','config_name' => 'editor_default',))
            ->add('sortOrder', 'number', array('attr' => array('class' => 'form-control')))
        ;
    }

    public function getName()
    {
        return 'english_slideshowbundle_slideshowtype';
    }
}
