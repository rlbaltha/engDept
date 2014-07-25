<?php

namespace English\GradcomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class GradcomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $position = 'Graduate Faculty';
        $builder
            ->add('gid','hidden')
            ->add('people', 'entity', array('label'=> 'Graduate Faculty Member','attr' => array('class' => 'form-control'),'class' => 'EnglishPeopleBundle:People','query_builder' => function(EntityRepository $er) use ($position) {
                return $er->createQueryBuilder('p')
                          ->join('p.position', 'o')
                          ->where("o.position = :position")
                          ->setParameter('position',$position)
                          ->orderBy('p.lastName', 'ASC');
              },'multiple' => false, 'property'=> 'lastName'
              ))    
            ->add('frole', 'choice', array('attr' => array('class' => 'form-control'),'choices' => array('1' => 'Member', '2' => 'Chair'),'required'  => true,'label'  => 'Committee Role'))
            ->add('status', 'hidden')             
        ;
    }

    public function getName()
    {
        return 'english_gradcombundle_gradcomtype';
    }
}
