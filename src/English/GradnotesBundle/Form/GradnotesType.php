<?php

namespace English\GradnotesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GradnotesType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('gid')
            ->add('notes')
        ;
    }

    public function getName()
    {
        return 'english_gradnotesbundle_gradnotestype';
    }
}
