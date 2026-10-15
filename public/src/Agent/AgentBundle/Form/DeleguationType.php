<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DeleguationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $fid=$options['fid'];
        $builder
                ->add('fonctionalite', null, ['attr' => ['class' => 'selectpicke', 'data-live-search' => 'true', 'style' => 'display:none;']])
                ->add('rubriques', 'entity', ['class' => 'AgentBundle:Rubriques',
                    'required' => false,
                    'empty_value' => '---- Choisir une rubrique ----',
                    'attr' => ['class' => 'selectpicke', 'data-live-search' => 'true'],
                    //'choice_label' => '',
                    'group_by' => 'fonctionalite',
                    'query_builder' => function(EntityRepository $er)use ($fid) {
                        return $er->createQueryBuilder('r');
                                  //  ->groupBy('r.fonctionalite');
                                //->where('r.fonctionalite =:fid')
                                //->setParameter('fid',$fid)
                                //->orderBy('r.libelle', 'ASC');
                    }
                ])
                ->add('agent', 'entity', ['class' => 'AgentBundle:Agent',
                    'required' => false,
                    'empty_value' => '---- Choisir un agent ----',
                    'attr' => ['class' => 'selectpicke', 'data-live-search' => 'true'],
                    'choice_label' => 'concatNom',
                    'group_by' => 'code_sd',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('agent')
                                ->where('agent.Fonction in (1,2) and agent.Direction = 3 ')
                                ->orderBy('agent.nom, agent.prenoms, agent.nomJeuneFille', 'ASC');
                    }
                ])
                ->add('responsable', 'entity', ['class' => 'AgentBundle:Agent',
                    'required' => false,
                    'empty_value' => '---- Choisir un responsable ----',
                    'attr' => ['class' => 'selectpicke', 'data-live-search' => 'true'],
                    'choice_label' => 'concatNom',
                    'group_by' => 'code_sd',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('agent')
                                ->where('agent.Fonction = 3 and agent.Direction = 3 ')
                                ->orderBy('agent.nom, agent.prenoms, agent.nomJeuneFille', 'ASC');
                    }
                ])
                //->add('deleguer')
                ->add('services', null, ['class' => 'AgentBundle:Direction', 'multiple' => true, 'expanded' => false, 'choice_label' => 'sigle', 'attr' => ['class' => 'selectpicke', 'data-live-search' => 'true']])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Deleguation',
             'fid'=>null
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_deleguation';
    }

}
