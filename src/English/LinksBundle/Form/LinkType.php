<?php

namespace English\LinksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
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
