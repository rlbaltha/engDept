<?php

namespace English\LinksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('title')
            ->add('type')
        ;
    }

    public function getName()
    {
        return 'english_linksbundle_linktype';
    }
}
