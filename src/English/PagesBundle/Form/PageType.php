<?php

namespace English\PagesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('menuName','text', array('attr' => array('class' => 'text form-control'),))
            ->add('link','text', array('label'=>'Link (if used will override link to page body)', 'attr' => array('class' => 'text form-control'),))
            ->add('pageBody', 'ckeditor', array('config_name' => 'editor_page',))
            ->add('section', 'entity', array('class' => 'EnglishPagesBundle:Section',
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Section', 'attr' => array('class' => 'form-control'),))
            ->add('parent', 'entity', array('class' => 'EnglishPagesBundle:Page',
                'property' => 'menuName','expanded'=>false,'multiple'=>false,'label'  => 'Parent page', 'required'=> false,'attr' => array('class' => 'form-control'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'English\PagesBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'english_pagesbundle_page';
    }
}
