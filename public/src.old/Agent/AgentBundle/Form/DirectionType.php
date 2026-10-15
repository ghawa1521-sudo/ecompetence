<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DirectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libDirect','text',array('label'=>'Libelle Direction'))
            ->add('sigle','text',array('label'=>'Sigle Direction'))
            ->add('siegeDirect','text',array('label'=>'Siege Direction'))
            ->add('immeuble','text',array('label'=>'Immeuble Direction'))
            ->add('etage','text',array('label'=>'Etage Direction'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Direction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent_agentbundle_direction';
    }
}
