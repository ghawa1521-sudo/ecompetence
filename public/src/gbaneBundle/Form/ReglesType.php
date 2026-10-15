<?php

namespace gbaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReglesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ancienneteGrade')
            ->add('ancienneteDge')
            ->add('FonctionAssimilees',null,['label'=>'Fonction Assimilee'])
            ->add('grade')
            ->add('pieces')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gbaneBundle\Entity\Regles'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gbanebundle_regles';
    }
}
