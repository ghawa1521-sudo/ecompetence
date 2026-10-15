<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class CompetenceRechercheType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $anneetotexp = array();
        $anneeexpdge = array();

        for ($i = 0; $i <= 35; $i++) {
            if ($i <= 9) {
                if ($i == 0 || $i == 1) {
                    $anneetotexp[$i] = "0" . $i . " an";
                    $anneeexpdge[$i] = "0" . $i . " an";
                } else {
                    $anneetotexp[$i] = "0" . $i . " ans";
                    $anneeexpdge[$i] = "0" . $i . " ans";
                }
            } else {
                $anneetotexp[$i] = $i . " ans";
                $anneeexpdge[$i] = $i . " ans";
            }
        }

        $builder

            ->add('anneetotexp', 'choice', array(
                'placeholder' => ' ',
                'choices' => $anneetotexp,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'label' => 'Années d\'experience cumulées'
            ))

            ->add('anneeexpdge', 'choice', array(
                'placeholder' => ' ',
                'choices' => $anneeexpdge,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'label' => 'Années d\'experience à la DGE'
            ))

            ->add('poste', 'entity', array(
                'class' => 'AgentBundle:Fonction',
                'query_builder' => function (EntityRepository $er) {
                    return $er->triFonction();
                },
                'required' => false,
            ))

            ->add('emploi', 'entity', array(
                'class' => 'AgentBundle:Emploi',
                'query_builder' => function (EntityRepository $er) {
                    return $er->triEmploi();
                },
                'required' => false,
            ))

            ->add('diplome', 'entity', array(
                'class' => 'EcompetenceBundle:Diplome',
                'property' => 'libDiplome',
                'required' => false,
                'attr' => array(
                    'onchange' => 'searchList1("#diplome","listespecialite","#specialite")'
                ),
                'label' => 'Diplôme'
            ))

            ->add('specialite', 'entity', array(
                'class' => 'EcompetenceBundle:Specialite',
                'required' => false,
                'property' => 'libspecialite',
                'attr' => array(
                    'onchange' => 'searchList1("#specialite","listeoption","#option")'
                ),
                'label' => 'Spécialité du diplôme'
            ))

            ->add('option', 'entity', array(
                'class' => 'EcompetenceBundle:Optiondiplome',
                'property' => 'libOption',
                'required' => false,
                'label' => 'Option de la spécialité'
            ))

            ->add('sexe', 'entity', array(
                'class' => 'AgentBundle:Sexe',
                'property' => 'libSexe',
                'required' => false,
            ))

            ->add('direction', 'entity', array(
                'class' => 'AgentBundle:Direction',
                'property' => 'libDirect',
                'required' => false,
                'placeholder' => '--- Choisir une direction ---',
            ))

            ->add('grade', 'entity', array(
                'class' => 'AgentBundle:Grade',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.libGrade', 'ASC');
                },
                'property' => 'libGrade',
                'attr' => array(
                    'onchange' => 'searchEmploi("#grade","listeemploi","#emploi")'
                ),
                'required' => false,
                'placeholder' => '--- Choisir un grade ---',
            ))

            ->add('Type', 'entity', array(
                'class' => 'AgentBundle:Type',
                'property' => 'libType',
                'placeholder' => '--- Choisir le type ---',
                'required' => false,
            ))

            ->add('secteur', 'entity', array(
                'class' => 'EcompetenceBundle:Secteur',
                'required' => false,
                'property' => 'libSecteur',
                'placeholder' => '---- Choisir du secteur ----',
                'attr' => array(
                    'id' => 'secteur',
                    'onchange' => 'searchSecteur("#secteur","listesecteur","#structure")'
                ),
                'label' => 'Nom du secteur'
            ))
          
            ->add('structure', 'entity', array(
                'class' => 'EcompetenceBundle:Structure',
                'required' => false,
                'placeholder' => '---- Choisir l\'employeur ----',
                'attr' => array(
                    'id' => 'structure',
                    // 'onchange' => 'searchList("#str","affecter_directiongeneral_listetype","#cvdg","#viewcvdg")'
                ),
                'label' => 'Nom de l\'employeur'
            ));
    }

    public function getName()
    {
        return 'comptence_ecompetencebundle_rechercher';
    }
}