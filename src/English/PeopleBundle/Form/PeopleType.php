<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('title')
            ->add('rank')
            ->add('address')
            ->add('address2')
            ->add('vitaUrl')
            ->add('username')
            ->add('officeHours')
            ->add('spouse')
            ->add('status')
            ->add('homePhone')
            ->add('cellPhone')
            ->add('email')
            ->add('officeNumber')
            ->add('officePhone')
            ->add('photoUrl')
            ->add('bio')
            ->add('area')
            ->add('homepageUrl')
            ->add('active')
            ->add('position')
        ;
    }

    public function getName()
    {
        return 'english_peoplebundle_peopletype';
    }
}
