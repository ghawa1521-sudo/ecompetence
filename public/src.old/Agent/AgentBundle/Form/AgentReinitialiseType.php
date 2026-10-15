<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Agent\AgentBundle\Form\AffecterType;

class AgentReinitialiseType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        //die;
        $builder
                //->add('matricule')
                //->add('Lieu_Naissance',NULL,['label' => 'Lieu de Naissance'])
                /* ->add('cvFile', 'vich_file' , array(
                  'label' => 'Choisir un CV',
                  'attr' => ['accept'=>".pdf", 'label'=>'Choisir un CV'],
                  'required'      => false,
                  'allow_delete'  => true, // not mandatory, default is true
                  'download_link' => true, // not mandatory, default is true
                  )) */
                ->add('users', 'entity', [
                    'label' => 'Saisir le matricule',
                    'class' => 'UsersBundle:Users',
                    'property' => 'username',
                    'required' => true,
                    'attr' => [
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => 'rechercher l\'agent',
                    'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:Agent',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('a')
                                ->orderBy('a.nom, a.prenoms', 'ASC');
                    }
                ])
                ->add('mdp', null, ['label' => "mot de passe"])

        //->add('telUrgent1')
        //->add('telUrgent2')
        //->add('Lieu_Naissance')
        //->add('telBur')
        //->add('telDom')
        ;
    }

    /**
      /* @param OptionsResolverInterface $resolver
      /**** */
    
      public function setDefaultOptions(OptionsResolverInterface $resolver)
      {
      $resolver->setDefaults(array(
       //'data_class' => 'Agent\AgentBundle\Entity\Agent',
            'validation_groups'=>false
      ));
      } 

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_reinitialise_password';
    }

}
