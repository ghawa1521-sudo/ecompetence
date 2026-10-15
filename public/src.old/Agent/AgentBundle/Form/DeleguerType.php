<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Agent\AgentBundle\Form\DeleguationType;

class DeleguerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
      $fid=$options['fid'];
        $builder
                //->add('date')
                ->add('deleguation', CollectionType::class, array(
                    // each entry in the array will be an "email" field
                    'entry_type' => DeleguationType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    // these options are passed to each "email" type
                    'entry_options' => array('fid'=>$fid
                    ),
                )) /*
          ->add('deleguation', 'collection', array('type' => new DeleguationType(),
          'allow_add' => true,
          'allow_delete' => true,))  /* */

        ;
        ;
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Deleguer',
            'fid'=>null
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_deleguer';
    }

}
