<?php

namespace Demandes\DemandesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\securityContext;
use Demandes\DemandesBundle\TypeDemande;
use Agent\AgentBundle\Form\DocumentType;

class DemandeNumeriseType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('demandeActe', new DocumentType())
                ->add('numActe', null, ['label' => 'Numero de la note', 'required' => true])
                ->add('dateNumActe', 'datetime', array('label' => 'Date de signature de la note', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                    'attr' => array('class' => 'form-control datetimepicker')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Demandes\DemandesBundle\Entity\Demande'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'demandes_demandesbundle_demande_numerise';
    }

}
