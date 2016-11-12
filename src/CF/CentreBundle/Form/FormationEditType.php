<?php

namespace CF\CentreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class FormationEditType extends AbstractType
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
            ->add('effacer', 'reset')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cf_centrebundle_formation_edit';
    }

    public function getParent()
    {
        return new FormationType();
    }
}
