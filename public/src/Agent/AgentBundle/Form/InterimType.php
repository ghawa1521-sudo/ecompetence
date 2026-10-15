<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;

//use Symfony\Component\Form\Extension\Core\Type\HiddenType;
//use Agent\AgentBundle\Entity\Direction;

class InterimType extends AbstractType {

    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public
            function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('interimaire', 'entity', ['class' => 'AgentBundle:Agent',
                    'required' => true,
                    'empty_value' => '---- Choisir votre intérimaire ----',
                    'attr' => ['class' => 'selectpicker', 'data-live-search' => 'true'],
                    'choice_label' => 'concatNom',
                    'query_builder' => function(EntityRepository $er) {
                        if ($this->user->getAgent()->getFonction()->getId() == 10) {
                            return $er->createQueryBuilder('agent')
                                    ->where('agent.Fonction in (:fonction)')
                                    ->andWhere('agent.matricule <>:mat')
                                    ->setParameter('fonction', [7,9])
                                    ->setParameter('mat', $this->user->getAgent()->getMatricule())
                                    ->orderBy('agent.nom, agent.prenoms, agent.nomJeuneFille', 'ASC');
                        } else {
                            return $er->createQueryBuilder('agent')
                                    ->where('agent.Fonction=:fonction')
                                    ->andWhere('agent.matricule <>:mat')
                                    ->setParameter('fonction', $this->user->getAgent()->getFonction()->getId())
                                    ->setParameter('mat', $this->user->getAgent()->getMatricule())
                                    ->orderBy('agent.nom, agent.prenoms, agent.nomJeuneFille', 'ASC');
                        }
                    }
                ])
        ->add('coordonnateur', 'entity', ['class' => 'AgentBundle:Agent',
                    'required' => false,
                    'empty_value' => '---- Choisir le coordonnateur technique ----',
                    'attr' => ['class' => 'selectpicker', 'data-live-search' => 'true'],
                    'choice_label' => 'concatNom',
                    'query_builder' => function(EntityRepository $er) {
                        if ($this->user->getAgent()->getFonction()->getId() == 10) {
                            return $er->createQueryBuilder('agent')
                                    ->where('agent.Fonction in (:fonction)')
                                    ->andWhere('agent.matricule <>:mat')
                                    ->setParameter('fonction', [7,9])
                                    ->setParameter('mat', $this->user->getAgent()->getMatricule())
                                    ->orderBy('agent.nom, agent.prenoms, agent.nomJeuneFille', 'ASC');
                        } else {

                                     return $er->createQueryBuilder('agent')
                                    ->where('agent.Fonction IN (:fonction) and agent.matricule <>:mat and agent.Direction =:dir')
                                    ->setParameter('dir', $this->user->getAgent()->getDirection())
                                    ->setParameter('fonction', [3,6])
                                    ->setParameter('mat', $this->user->getAgent()->getMatricule())
                                    ->orderBy('agent.nom, agent.prenoms, agent.nomJeuneFille', 'ASC');

                        }
                    }
                ])
                // ->add('datedebut', DateType::class, array('widget' => 'single_text','format' => 'yyyy-MM-dd'))
                // ->add('datefin', DateType::class, array( 'widget' => 'single_text','format' => 'yyyy-MM-dd'))
                ->add('datedebut', 'datetime', array('required' => false, 'label' => 'Du', 'widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i', 'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('datefin', 'datetime', array('required' => false, 'label' => 'Au', 'widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i', 'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'form-control datetimepicker')));
    }

    /**
     * @return string
     */
    public
            function getName() {
        return 'agent_agentbundle_interim';
    }

}
