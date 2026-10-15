<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Agent\AgentBundle\Form\PjType;
use Agent\AgentBundle\Form\DecisionAgentType;

class DecisionAgentType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->remove('date')
                ->remove('numero')
                ->remove('exercice')
                ->remove('direction')
                ->remove('pj')
        
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */


    /**
     * @return string
     */
    public function getParent() {
        return DecisionType::class;
    }

}
