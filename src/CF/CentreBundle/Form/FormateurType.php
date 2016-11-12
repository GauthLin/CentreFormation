<?php

namespace CF\CentreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text')
            ->add('prenom', 'text')
            ->add('gsm', 'text')
            ->add('email', 'email')
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
            'data_class' => 'CF\CentreBundle\Entity\Formateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cf_centrebundle_formateur';
    }
}
