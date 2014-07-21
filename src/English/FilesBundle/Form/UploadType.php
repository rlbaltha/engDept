<?php

namespace English\FilesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file')
            ->add('name','text', array('attr' => array('class' => 'text form-control'),))
            ->add('label', 'entity', array('class' => 'EnglishFilesBundle:Label','property'=>'name','attr' => array('class' => 'text form-control'), 'query_builder' =>
                 function(\English\FilesBundle\Entity\LabelRepository $er) {
                 return $er->createQueryBuilder('l')
                 ->where('l.display = :display')
                 ->setParameter('display', TRUE)          
                 ->orderBy('l.name', 'ASC');
                 }))   
            ->add('description','textarea', array('attr' => array('class' => 'text form-control'),))
            ->add('path', 'hidden')
        ;
    }

    public function getName()
    {
        return 'english_filesbundle_filetype';
    }
}
