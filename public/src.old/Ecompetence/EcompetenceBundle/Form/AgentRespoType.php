<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Agent\AgentBundle\Entity\Agent;
use Ecompetence\EcompetenceBundle\Entity\Responsabilite_extra;

use Doctrine\ORM\EntityRepository;

class AgentRespoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
  

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('responsabilite', CollectionType::class, array(
            'entry_type' => Responsabilite_extraType::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
        ->add('enregistrer', 'submit', array('label' => 'Enregistrer'));
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Agent'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_respo';
    }

}
