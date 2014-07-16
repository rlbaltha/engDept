<?php

namespace English\AreasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('area','text', array('attr' => array('class' => 'text form-control'),))
        ;
    }

    public function getName()
    {
        return 'english_areasbundle_areatype';
    }
}
