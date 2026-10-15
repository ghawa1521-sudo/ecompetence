<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Form\AdresseType;
use Agent\AgentBundle\Entity\Direction;
use Agent\AgentBundle\Form\AffecterType;
use Agent\AgentBundle\Entity\ServiceDirection;
use Agent\AgentBundle\Entity\SousDirection;

class AgentType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private $todo;

    public function __construct($todo, $dir = null) {
        $this->todo = $todo;
        $this->dir = $dir;
        //var_dump($this->todo);
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        switch ($this->todo) {

            //agent
            case 0:
//die;
                $builder
                        ->add('matricule', NULL, ['attr' => ['required' => true]])
                        ->add('nom')
                        ->add('prenoms')
                        ->add('nomJeuneFille')
                        ->add('dateNaiss', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy',
                            'attr' => array('class' => 'form-control datetimepicker')))
                        ->add('situationMili')
                        ->add('nomPere')
                        ->add('nomMere')
                        ->add('situationMatri')
                        ->add('nbEnf')
                        ->add('indice', null, array('attr' => ['style' => 'pointer-events:none;']))
                        ->add('datePremierService', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => false,
                            'attr' => array('class' => 'form-control datetimepicker')))
                        ->add('datePriseServiceDge', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => false,
                            'attr' => array('class' => 'form-control datetimepicker')))
                        ->add('imageFile', 'vich_file', array(
                            'label' => ' ',
                            'required' => false,
                            'allow_delete' => true, // not mandatory, default is true
                            'download_link' => true, // not mandatory, default is true
                        ))
                        ->add('telBur')
                        ->add('telPort')
                        ->add('telDom')
                        ->add('quartier')
                        ->add('nomConjoint')
                        ->add('telConjoint')
                        ->add('descriComp')
                        ->add('cvFile', 'vich_file', array(
                            'label' => ' ',
                            'required' => false,
                            'allow_delete' => true, // not mandatory, default is true
                            'download_link' => true, // not mandatory, default is true
                        ))
                        ->add('telUrgent1')
                        ->add('telUrgent2')
                        ->add('Provenance', NULL, ['attr' => [
                                'style' => 'color:green',
                                'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir'], 'label' => 'Provenance'
                        ])
                        ->add('Type')
                        ->add('Fonction')
                        ->add('Emploi', null, [
                            'class' => 'AgentBundle:Emploi',
                            'query_builder' => function(EntityRepository $er) {
                                $querybuilder = $er->triEmploi();
                                return $querybuilder;
                            },
                            /* 'empty_value' => '-- Sélectionner le rôle de l\'Agent --', */
                            'attr' => [
                                'style' => 'color:green',
                                'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir'],
                        ])
                        ->add('Titre')
                        ->add('Classe')
                        ->add('Lieu_Naissance', null, [
                            'attr' => ['class' => 'selectpicker',
                                'data-live-search' => 'true',
                                'title' => 'Choisir l\'agent'], 'label' => 'Lieu de naissance'])
                        ->add('Promotion')
                        ->add('Syndicat', NULL, [
                            'empty_value' => '-- Sélectionner le Syndicat --'
                        ])
                        ->add('Sexe')
                        ->add('Direction')
                        ->add('Echelon')

                        //->add('Grade')
                        ->add('email', 'email')
                        ->add('emailPerso', 'email')
                        ->add('adresse', CollectionType::class, array(
                            'entry_type' => AdresseType::class,
                            'entry_options' => array('label' => false),
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                        ))
                        ->add('persUrgent1')
                        ->add('persUrgent2')
                        ->add('code_dg', NULL, ['label' => 'Direction Générale',
                            'empty_value' => '---- Choisir la Direction Générale ----',
                            'attr' => array('onchange' => 'searchList("#dg","affecter_directioncentrale_listetype","#dc", "#viewdc")')
                        ])
                        ->add('code_dc')
                        ->add('Direction', NULL, ['label' => 'Directions / Services Rattachés', 'empty_value' => '---- Choisir Direction / Services Rattachés ----', 'attr' => array('onchange' => 'searchList("#dc","affecter_sousDirection_listetype","#sd", "#viewsd")')])
                        ->add('code_sd', NULL, ['label' => 'Sous-Direction', 'empty_value' => '---- Choisir la Sous-Direction ----', 'attr' => array('onchange' => 'searchList("#sd","affecter_serviceDirection_listetype","#sc", "#viewsc")')])
                        ->add('code_sc', NULL, ['label' => 'Service', 'empty_value' => '---- Choisir le Service ----']);
                break;
            /*
              ->add('role',NULL,[
              'class'=>'AgentBundle:RoleAgent',
              'query_builder'=>function(EntityRepository $er) {
              $querybuilder = $er->triRole();
              return $querybuilder;
              },
              'empty_value' => '-- Sélectionner le rôle de l\'Agent --',
              ])
              ;
              break; */
            //enregistrer nouvel agent affecter
            case 1:
                //die;
                $builder
                        ->add('matricule')
                        ->add('Sexe', NULL, ['label' => 'Civilité'])
                        ->add('nom', NULL, ['label' => 'Nom'])
                        ->add('prenoms', NULL, ['label' => 'Prénoms'])
                        ->add('nomJeuneFille', NULL, ['label' => 'Nom de Jeune Fille'])
                        ->add('dateNaiss', 'datetime', array('label' => 'Date de Naissance', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i',
                            'attr' => array('class' => 'form-control datetimepicker')))
                        ->add('situationMatri', NULL, ['label' => 'Situation Matrimoniale'])
                        ->add('descriComp', NULL, ['label' => 'Description des Compétences'])
                        ->add('Direction', NULL, ['label' => 'Direction', 'empty_value' => 'Choisir la Direction d\'Affectation'])
                        ->add('Type', NULL, ['label' => 'Type d\'Agent'])
                        ->add('Emploi', NULL, [
                            'class' => 'AgentBundle:Emploi',
                            'query_builder' => function(EntityRepository $er) {
                                $querybuilder = $er->triEmploi();
                                return $querybuilder;
                            },
                            /* 'empty_value' => '-- Sélectionner le rôle de l\'Agent --', */
                            'attr' => [
                                'style' => 'color:green',
                                'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir'],
                        ])
                        ->add('Fonction')
                        ->add('Lieu_Naissance', NULL, ['attr' => [
                                'style' => 'color:green',
                                'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir'], 'label' => 'Lieu de naissance'
                        ])
                        ->add('cvFile', 'vich_file', array(
                            'label' => ' ',
                            'attr' => ['accept' => ".pdf"],
                            'required' => false,
                            //'constraint'=> [],
                            'allow_delete' => true, // not mandatory, default is true
                            'download_link' => true, // not mandatory, default is true
                        ))
                        ->add('imageFile', 'vich_file', array(
                            'label' => ' ',
                            'attr' => ['accept' => "image/*"],
                            'required' => false,
                            'allow_delete' => true, // not mandatory, default is true
                            'download_link' => true, // not mandatory, default is true
                        ))
                        ->add('nbEnf')
                        ->add('indice', null, array('attr' => ['style' => 'pointer-events:none;']))
                        ->add('datePremierService', 'datetime', array('label' => 'Date 1ère prise de Service', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'required' => false,
                            'attr' => array('class' => 'form-control datetimepicker')))
                        ->add('situationMili')
                        ->add('nomPere')
                        ->add('nomMere')
                        ->add('situationMatri')
                        ->add('telUrgent1')
                        ->add('telUrgent2')
                        ->add('Provenance')
                        ->add('Type')
                        ->add('Titre')
                        ->add('Classe')
                        //->add('Lieu_Naissance')
                        ->add('Promotion')
                        ->add('Syndicat', NULL, [
                            'empty_value' => '-- Sélectionner le Syndicat --'
                        ])
                        ->add('Echelon')
                        ->add('email', 'email')
                        ->add('emailPerso', 'email', array('required' => false))
                        ->add('adresse', CollectionType::class, array(
                            'entry_type' => AdresseType::class,
                            'entry_options' => array('label' => false),
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                        ))
                        ->add('telBur')
                        ->add('telPort')
                        ->add('telDom')
                        ->add('quartier')
                        ->add('nomConjoint')
                        ->add('telConjoint')
                        ->add('persUrgent1')
                        ->add('persUrgent2')
                /*
                  ->add('role',NULL,[
                  'class'=>'AgentBundle:RoleAgent',
                  'query_builder'=>function(EntityRepository $er) {
                  $querybuilder = $er->triRole();
                  return $querybuilder;
                  },
                  'empty_value' => '-- Sélectionner le rôle de l\'Agent --',
                  ]) */
                ;
                break;
            case 2:
                $builder
                        ->add('code_dg', NULL, ['label' => 'Direction Générale', 'empty_value' => '---- Choisir la Direction Générale ----', 'attr' => array('onchange' => 'searchList("#dg","affecter_directioncentrale_listetype","#dc", "#viewdc")')])
                        /* ->add('Direction', NULL, ['label' => 'Directions / Services Rattachés', 'empty_value' => '---- Choisir Direction / Services Rattachés ----', 'attr' => array('onchange' => 'searchList("#dc","affecter_sousDirection_listetype","#sd", "#viewsd")')]) */
                        ->add('code_sd', NULL, ['label' => 'Sous-Direction', 'empty_value' => '---- Choisir la Sous-Direction ----', 'attr' => array('onchange' => 'searchList("#sd","affecter_serviceDirection_listetype","#sc", "#viewsc")')])
                        ->add('code_sc', NULL, ['label' => 'Service', 'empty_value' => '---- Choisir le Service ----'])
                        ->add('Direction', NULL, ['label' => 'Directions / Services Rattachés',
                            'class' => 'AgentBundle:Direction',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d')->where('d.rang > 2 or d.id = 16')
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
                                    8 => 'Cellules'
                                ];


                                //  if ($direction->getEtatDirection() >= 0 and isset($tab[$direction->getEtatDirection()])){
                                if (in_array($direction->getEtatDirection(), array_keys($tab))) {

                                    return $tab[$direction->getEtatDirection()];
                                } else {
                                    return 'autres';
                                }
                            }]);

                break;
            case 3:
                //dump($this->dir); die;
                $builder
                        ->add('code_sd', null, ['label' => 'Sous direction', 'placeholder' => '--- Choisir la sous-direction ---',
                            'attr' => ['data-display' => 'Select', 'class' => 'code_sd'],
                            'class' => 'AgentBundle:SousDirection',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d')->where('d.code_dc = :CODE_DC')
                                        ->setParameter('CODE_DC', $this->dir);
                            },
                            'choice_attr' => function ($code_sd, $key, $value) {
                                return ['data-chained' => ($code_sd->getCodeDc()->getCodeDc()),
                                ];
                            },
                        ])
                        ->add('code_sc', null, ['label' => 'Service', 'placeholder' => '--- Choisir le service ---',
                            'attr' => ['data-display' => 'Select', 'class' => 'code_sc'],
                            'choice_attr' => function ($code_sc, $key, $value) {
                                return ['data-chained' => ($code_sc->getCodeSousDir()->getCodeSd()),
                                ];
                            },
                ]);
                break;
        }
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
        return 'agent_agentbundle_agent';
    }

}
