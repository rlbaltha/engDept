<?php

namespace English\PublicationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PublicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'ckeditor', array('config_name' => 'editor_default',))
        ;
    }

    public function getName()
    {
        return 'english_publicationsbundle_publicationstype';
    }
}
