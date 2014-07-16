<?php

namespace English\LinksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url','text', array('attr' => array('class' => 'text form-control'),))
            ->add('title','text', array('attr' => array('class' => 'text form-control'),))
            ->add('type','text', array('attr' => array('class' => 'text form-control'),))
        ;
    }

    public function getName()
    {
        return 'english_linksbundle_linktype';
    }
}
