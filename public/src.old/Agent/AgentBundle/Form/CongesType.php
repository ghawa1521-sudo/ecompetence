<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Form\NumerisationType;
use Agent\AgentBundle\Form\NumerisationRType;

class CongesType extends AbstractType
{

    private $todo;
    private $matricule;
    private $periodes;

    public function __construct($todo = 0, $matricule, $periodes = null)
    {
        $this->todo = $todo;
        $this->matricule = $matricule;
        $this->periodes = $periodes;
        //var_dump($this->todo);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $etat = array(
            //null=>"-- Sélectionner la Destination --",
            0 => "A l'intérieur du pays",
            1 => "A l'extérieur"
        );
        if ($this->periodes) {
            foreach ($this->periodes as $value) {
                $tab[] = $value->getDuree();
            }
        }


        switch ($this->todo) {
            case 1: //Cas de Refus
                //echo $this->todo;
                $builder
                    ->add('objetRefus');
                break;

            case 2:
                $builder
                    ->add('datereprise', 'datetime', array(
                        'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'label' => 'Date de reprise',
                        'attr' => array('class' => 'form-control date1', 'autocomplete' => false)
                    ));

                break;

            case 3: //cas de numérisation
                $builder
                    ->add('numCessation', new NumerisationRType(), [
                        'attr' => array('required' => true)
                    ]);
                break;
            case 4: //cas de numérisation
                $builder
                    ->add('numReprise', new NumerisationRType(), [
                        'required' => true
                    ]);
                break;

            default: //Cas général
                foreach ($this->periodes as $period) {
                    $periode[$period->getDuree()] = $period->getDuree() . ' ' . $period->getLibelle();
                }
                $builder
                    //->add('datecreation')
                    ->add('typeConges', null, [
                        'attr' => array('required' => 'true', 'class' => 'tp'),
                        'empty_value' => '-- Choisir le type de congé --',
                        //'property' => 'nomSite',
                        'multiple' => FALSE,
                        'class' => 'AgentBundle:TypeConges',
                        'query_builder' => function (EntityRepository $er) {
                            $querybuilder = $er->FindTypeConges($this->matricule); //Retrouver les de l'agent
                            return $querybuilder;
                        }
                    ])
                    ->add('exercice', null, [
                        'attr' => array('required' => false, 'class' => ''),
                        'empty_value' => '-- Choisir l\'exercice --',
                        //'property' => 'nomSite',
                        'multiple' => FALSE,
                        'class' => 'AgentBundle:Exercice',
                        'query_builder' => function (EntityRepository $er) {
                            $querybuilder = $er->exerciceActif($this->matricule); //Retrouver les de l'agent
                            return $querybuilder;
                        }
                    ])

                    /*
                          ->add('typeConges', null, [
                          'required' => true,
                          'empty_value' => '-- Choisir le type de congé --']) */
                    ->add('datedebut', 'datetime', array(
                        'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'label' => 'Date de départ',
                        'attr' => array('class' => 'form-control date1', 'autocomplete' => 'false')
                    ))
                    ->add('externe', 'choice', array(
                        'empty_value' => '-- Sélectionner la Destination --', 'label' => 'Destination', 'choices' => $etat,
                        'expanded' => false,
                        'multiple' => false,
                        'required' => true,
                    ))
                    ->add('objetFile', 'vich_file', array(
                        'required' => false,
                        'allow_delete' => true, // not mandatory, default is true
                        'download_link' => true,
                        'label' => 'Pièce Justificative', // not mandatory, default is true
                    ))

                    /*
                    ->add('nbrejours', 'choice', array(
                        'empty_value' => '-- Choisir le Nombre de jours --', 'label' => 'Nombre de jours', 'choices' => $periode,
                        'expanded' => false,
                        'multiple' => false,
                        'required' => true,
                        'attr' => array('style' => 'display:none; ', 'class' => 'periodes')
                    ))
*/
                    ->add('nbrejours', 'entity', [
                        'placeholder' => '-- Choisir le Nombre de jours --',
                        'attr' => [
                            'required' => true,
                            'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => '-- Choisir le Nombre de jours --'
                        ], 'label' => 'Nombre de jours',
                        'class' => 'AgentBundle:PeriodeConges',
                        'choice_attr' => function ($nb, $key, $value) {
                            return [
                                'data-chained' => ($nb->getTypeConges()->getId()),
                            ];
                        },
                        'query_builder' => function (EntityRepository $repo) use ($tab) {
                            return $repo->createQueryBuilder('pc')
                                ->where('(pc.duree in (:tab) and pc.typeConges=1) or pc.typeConges<>1')
                                ->setParameter('tab', $tab);
                        }
                    ]);


                break;
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        if ($this->matricule->getFonction()->getId() > 2) {
            $tab = array(
                'data_class' => 'Agent\AgentBundle\Entity\Conges',
                'user' => null,
                'validation_groups' => false
            );
        } else {
            $tab = array(
                'data_class' => 'Agent\AgentBundle\Entity\Conges',
                'user' => null,
            );
        }
        $resolver->setDefaults($tab);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent_agentbundle_conges';
    }
}
