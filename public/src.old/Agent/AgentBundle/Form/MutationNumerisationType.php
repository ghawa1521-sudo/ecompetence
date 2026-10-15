<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Entity\Direction;

class MutationNumerisationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('mutationNote', new DocumentType())
                ->add('numNote', null, ['label' => 'Numero de la note', 'required' => true])
                ->add('dateNoteMutation', 'datetime', array('label' => 'Date de signature de la note', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                    'attr' => array('class' => 'form-control datetimepicker')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Mutation'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_mutation';
    }

}
