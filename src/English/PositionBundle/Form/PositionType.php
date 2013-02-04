<?php

namespace English\PositionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position')
        ;
    }

    public function getName()
    {
        return 'english_positionbundle_positiontype';
    }
}
