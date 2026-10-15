<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Entity\Direction;

class MutationDgType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('emmeteur', NULL, ['attr' => [
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => 'Agent à muter',
                    'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:Agent',
                    'group_by'=>'Direction',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('a')
                                ->orderBy('a.nom, a.prenoms', 'ASC')
                        ;
                    }])
                ->add('destination', NULL, ['label' => 'Direction Souhaitée',
                    'class' => 'AgentBundle:Direction',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('d')->where('1=1')
                                ->orderBy('d.etatDirection', 'DESC')
                                ->orderBy('d.rang', 'ASC')
                        ;
                    },
                    'group_by' => function(Direction $direction) {
                        $tab = [
                            0 => 'Services Rattachés',
                            1 => 'Direction',
                            2 => 'DGA',
                            3 => 'Secrétariat',
                            4 => 'Cabinet',
                            5 => 'Service Courrier',
                            8 => 'Cellules'];


                        //  if ($direction->getEtatDirection() >= 0 and isset($tab[$direction->getEtatDirection()])){
                        if (in_array($direction->getEtatDirection(), array_keys($tab))) {

                            return $tab[$direction->getEtatDirection()];
                        } else {
                            return 'autres';
                        }
                    }])

        //->add('Observ','textarea',['label' => 'motifs de la Mutation'])

        ;
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
