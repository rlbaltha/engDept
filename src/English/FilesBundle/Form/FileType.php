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
            ->add('label', 'entity', array('class' => 'EnglishFilesBundle:Label','property'=>'name', 'query_builder' => 
                 function(\English\FilesBundle\Entity\LabelRepository $er) {
                 return $er->createQueryBuilder('l')
                 ->where('l.display = :display')
                 ->setParameter('display', TRUE)          
                 ->orderBy('l.name', 'ASC');
                 }))   
            ->add('description', 'text', array('attr' => array('class' => 'width300')))    
            ->add('path', 'hidden')
        ;
    }

    public function getName()
    {
        return 'english_filesbundle_filetype';
    }
}
