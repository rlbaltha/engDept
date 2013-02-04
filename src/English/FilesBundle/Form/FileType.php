<?php

namespace English\FilesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'text', array('attr' => array('class' => 'width300')))    
            ->add('path', 'hidden')
        ;
    }

    public function getName()
    {
        return 'english_filesbundle_filetype';
    }
}
