<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PjRType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
                ->add('imageFile', 'vich_file', array(
                    'required' => true,
                    'allow_delete' => true, // not mandatory, default is true
                    'download_link' => true,
                    //'label' => '  ', // not mandatory, default is true
                )
            
        )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Pj'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_pj';
    }

}
