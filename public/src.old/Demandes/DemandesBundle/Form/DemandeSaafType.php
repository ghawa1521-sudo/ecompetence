<?php

namespace Demandes\DemandesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\securityContext;
use Demandes\DemandesBundle\TypeDemande;
use Doctrine\ORM\EntityRepository;

class DemandeSaafType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $agent = $options['agent'];
        $builder
                ->add('emmeteur', NULL, ['attr' => [
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true',
                        'title' => 'Choisir l\'agent'],
                    'label' => 'Agent',
                    'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:Agent',
                    'group_by' => 'fonction',
                    'query_builder' => function(EntityRepository $repo) use ($agent) {
                        return $repo->createQueryBuilder('a')
                                ->where('a.code_dc= :code_dc')
                                ->orderBy('a.nom, a.prenoms', 'ASC')
                                ->setParameter('code_dc', $agent->getCodeDC())
                        ;
                    }])
                ->add('typeDemande', NULL, [
                    'label' => 'Type de la Demande',
                    'attr' => ['class' => ''],
                    'class' => 'DemandesBundle:TypeDemande',
                    'empty_value' => '-- Sélectionner le type de la Demande --'])
                ->add('dateDeb', 'datetime', array('required' => false, 'label' => 'Date de Début', 'widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i', 'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('dateFin', 'datetime', array('required' => false, 'label' => 'Date de Fin', 'widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i', 'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('objet', NULL, ['required' => true, 'label' => 'Motif de la demande'])
                ->add('destination')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Demandes\DemandesBundle\Entity\Demande',
            'agent' => null
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'demandes_demandesbundle_demande';
    }

}
