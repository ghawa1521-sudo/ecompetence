<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Form\PjRType;

class NumerisationRType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'datetime', array('required' => true, 'label'=>'Date numérisation','widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i',
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('pj', new PjRType(), [
                    'required' => true,'label'=>' ',])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Numerisation'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_numerisation';
    }

}
