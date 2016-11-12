<?php

namespace CF\CentreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FormateurEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('ajouter', 'submit')
            ->add('modifier', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cf_centrebundle_formateur_edit';
    }

    public function getParent()
    {
        return new FormateurType();
    }
}
