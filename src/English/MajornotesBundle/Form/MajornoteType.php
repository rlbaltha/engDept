<?php

namespace English\MajornotesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MajornoteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('mentorId')
            ->add('mentor')
            ->add('notes')
        ;
    }

    public function getName()
    {
        return 'english_majornotesbundle_majornotetype';
    }
}
