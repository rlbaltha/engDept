<?php

namespace English\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DetailType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startterm','entity', array('label'=> 'Start term','class'=>'EnglishTermBundle:Term', 'property'=>'termName',
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.term', 'DESC'); },
                    'expanded'=>false,'multiple'=>false, 'required' => false,))
            ->add('endterm','entity', array('label'=> 'Completion term','class'=>'EnglishTermBundle:Term', 'property'=>'termName',
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.term', 'DESC'); },
                'expanded'=>false,'multiple'=>false, 'required' => false,))
            ->add('accomplishments', 'ckeditor', array('required' => false,'label'=> 'Accomplishments','config_name' => 'editor_simple',))
            ->add('placement', 'ckeditor', array('required' => false,'label'=> 'Placement','config_name' => 'editor_simple',))
            ->add('courseloadF', 'choice', array('label'=> 'Course load Fall','choices'   => array('0' => '0','1' => '1', '2' => '2', '3' => '3', '4' => '4'),'required'  => false,  'expanded' => true,))
            ->add('courseloadS', 'choice', array('label'=> 'Course load Spring','choices'   => array('0' => '0','1' => '1', '2' => '2', '3' => '3', '4' => '4'),'required'  => false,  'expanded' => true,))
            ->add('homeDept', 'text', array('attr' => array('class' => 'form-control')))
            ->add('appCompleted', 'choice', array('label'=> 'Completed apprenticeship','choices'   => array('Yes' => 'Yes', 'No' => 'No', 'NR' => 'NR'),
                'required'  => true, 'expanded' => true,))
            ->add('appWith', 'text', array('label'=> 'Apprenticed with','required'  => false,'attr' => array('class' => 'form-control')))
            ->add('homeDept', 'choice', array('label'=> 'Home department','choices'   => array('Eng' => 'Eng', 'Ling' => 'Ling'),'required'  => true,  'expanded' => true,))
            ->add('notes', 'ckeditor', array('required' => false,'label'=> 'Notes','config_name' => 'editor_simple',))        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'English\PeopleBundle\Entity\Detail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'english_peoplebundle_detail';
    }
}
