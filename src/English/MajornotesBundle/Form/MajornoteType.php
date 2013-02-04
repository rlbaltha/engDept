<?php

namespace English\MajornotesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MajornoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mentorId', 'hidden')
            ->add('notes')
        ;
    }

    public function getName()
    {
        return 'english_majornotesbundle_majornotetype';
    }
}
