<?php

namespace English\PublicationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PublicationsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'english_publicationsbundle_publicationstype';
    }
}
