<?php

namespace Agent\IdentificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Form\DecisionType;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Form\NumerisationType;
use Agent\AgentBundle\Form\NumerisationRType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PassifcongeType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $users=$options['users'];
    
        $etat = array(
            //null=>"-- Sélectionner la Destination --",
            0 => "A l'intérieur du pays",
            1 => "A l'extérieur");
        $periode = array(
            //null=>"-- Sélectionner la Destination --",
            15 => '15 jours',
            30 => '30 jours');
        $builder
                      //ajout decision
                        
                      
                      //ajout agent sur decision

                    //demande de conge annuel

                    //validation par superieur

                    //generation cessation

                    //numerisation cessation

                    //validation date de reprise de service



                       ->add('agent', NULL, ['attr' => [
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => ' ',
                    'choice_label' => 'concatNommatricule',
                    'class' => 'AgentBundle:Agent',
                    'group_by' => 'code_sd',
                    'query_builder' => function(EntityRepository $repo) use ($users) {
                        $respo = $repo->createQueryBuilder('a')
                                    ->where('1=1');
                                    if($users->hasRole('ROLE_SAAF'))
                                    {
                                      $respo = $respo->andWhere('a.Direction = :service')
                                                     ->setParameter('service', $users->getAgent()->getDirection());
                                                     //->groupBy('a.code_sd, a.code_sc');  
                                    }
                                    $respo = $respo->orderBy('a.Direction,a.code_sd,a.nom, a.prenoms', 'ASC');
                        
                        return $respo;
                    }])

                        
                        //->add('datecreation')
                        //->add('decision', new DecisionType(), [])
                        ->add('typeConges', null, [
                            'attr' => array('required' => 'true', 'class' => 'tp'),
                            'empty_value' => '-- Choisir le type de congé --',
                            //'property' => 'nomSite',
                            'multiple' => FALSE,
                            'class' => 'AgentBundle:TypeConges',
                           /* 'query_builder' => function(EntityRepository $er) {
                                $querybuilder = $er->FindTypeConges($this->matricule); //Retrouver les de l'agent
                                return $querybuilder;
                            }*/
                        ])
                        ->add('exercice', null, [
                            'attr' => array('required' => false, 'class' => ''),
                            'empty_value' => '-- Choisir l\'exercice --',
                            //'property' => 'nomSite',
                            'multiple' => FALSE,
                            'class' => 'AgentBundle:Exercice',
                            /*'query_builder' => function(EntityRepository $er) {
                                $querybuilder = $er->exerciceActif($this->matricule); //Retrouver les de l'agent
                                return $querybuilder;
                            }
                            */
                        ])

                        /*
                          ->add('typeConges', null, [
                          'required' => true,
                          'empty_value' => '-- Choisir le type de congé --']) */
                        ->add('datedebut', DateTimeType::class, array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'label' => ' ',
                            'attr' => array('class' => 'form-control date1', 'autocomplete' => 'false')))
                        ->add('datefin', DateTimeType::class, array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'label' => ' ',
                            'attr' => array('class' => 'form-control date1', 'autocomplete' => 'false')))
                        ->add('externe', 'choice', array('empty_value' => '-- Sélectionner la Destination --', 'label' => 'Destination', 'choices' => $etat,
                            'expanded' => false,
                            'multiple' => false,
                            'required' => true,
                        ))
                        ->add('objetFile', 'vich_file', array(
                            'required' => false,
                            'allow_delete' => true, // not mandatory, default is true
                            'download_link' => true,
                            'label' => 'Pièce Justificative', // not mandatory, default is true
                ))->add('nbrejours', 'choice', array('empty_value' => '-- Choisir le Nombre de jours --', 'label' => 'Nombre de jours', 'choices' => $periode,
                        'expanded' => false,
                        'multiple' => false,
                        'required' => false,
                        'attr' => array('class' => 'periodes')))


                ->add('datereprise', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'label' => 'Date de reprise',
                            'attr' => array('class' => 'form-control date1', 'autocomplete' => false)))
                ->add('numCessation', new NumerisationRType(), ['label' => false,
                            'attr' => array('required' => true)])
                
                //->add('numReprise', new NumerisationType(), [
//                            'required' => true]);



                ;
               
    }

   
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Conges',
            'validation_groups'=>false,
            'users'=>null
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_Identificationbundle_passifconge';
    }

}
