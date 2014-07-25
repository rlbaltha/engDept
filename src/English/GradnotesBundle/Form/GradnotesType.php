<?php

namespace English\GradnotesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GradnotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gid','hidden')
            ->add('notes', 'ckeditor', array('config_name' => 'editor_simple',))
        ;
    }

    public function getName()
    {
        return 'english_gradnotesbundle_gradnotestype';
    }
}
