<?php

namespace CF\CentreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text')
            ->add('date', 'datetime')
            ->add('duree', 'number')
            ->add('formateur', 'entity', array(
                'class' => 'CFCentreBundle:Formateur',
                'property' => 'getNomComplet',
                'multiple' => false,
                'required' => false,
                'empty_value' => '-- Aucun formateur --',
            ))
            ->add('ajouter', 'submit')
            ->add('effacer', 'reset')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CF\CentreBundle\Entity\Formation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cf_centrebundle_formation';
    }
}
