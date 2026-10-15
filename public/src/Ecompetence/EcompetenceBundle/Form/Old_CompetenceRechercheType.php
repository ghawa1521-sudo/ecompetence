<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class CompetenceRechercheType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

           
         $anneetotexp= array();
         $anneeexpdge= array();
         for($i=0;$i<=35;$i++)     
         {  if($i<=9)
            {
             if($i==0||$i==1)
             { 
                $anneetotexp[$i]="0".$i." an";
                $anneeexpdge[$i]="0".$i." an";  
             } 
             else
             {    
                $anneetotexp[$i]="0".$i." ans";
                $anneeexpdge[$i]="0".$i." ans"; 
             }
             
            }
            else
            {
             $anneetotexp[$i]=$i." ans";
             $anneeexpdge[$i]=$i." ans";   
            }
         }
        
        $builder
                 ->add('anneetotexp','choice', array(
                    'placeholder' => ' ',
                  //  'attr' => array('class'=>'selectpicker','data-live-search'=>true),
                    'choices' => $anneetotexp,
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'label' => 'Années d\'experience'))
                  ->add('anneeexpdge','choice', array(
                    'placeholder' => ' ',
                  //  'attr' => array('class'=>'selectpicker','data-live-search'=>true),
                    'choices' => $anneeexpdge,
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'label' => 'Années d\'experience à la DGE'))
               
                ->add('poste', 'entity', [
                    'class' => 'AgentBundle:Fonction',
                   // 'attr' => array('class'=>'selectpicker','data-live-search'=>true),
                    'query_builder' => function(EntityRepository $er) {
                                $querybuilder = $er->triFonction();
                                return $querybuilder;},
                    'required' => false,
                ])
                ->add('emploi', 'entity', [
                    'class' => 'AgentBundle:Emploi',
                   // 'attr' => array('class'=>'selectpicker','data-live-search'=>true),
                    'query_builder' => function(EntityRepository $er) {
                                $querybuilder = $er->triEmploi();
                                return $querybuilder;},
                    
                    'required' => false,
                ])
                ->add('diplome', 'entity', [
                    'class' => 'EcompetenceBundle:Diplome',
                    'property' => 'libDiplome',
                    'required' => false,
                    'attr' => array('onchange' => 'searchList1("#diplome","listespecialite","#specialite")'),
                    'label'=>'Diplôme'
                ])
                 ->add('specialite', 'entity', [
                    'class' => 'EcompetenceBundle:Specialite',
                    'required' => false,
                    'property' => 'libspecialite',
                    'attr' => array('onchange' => 'searchList1("#specialite","listeoption","#option")'),
                    'label'=>'Spécialité du dipôme'
                ])
                  ->add('option', 'entity', [
                    'class' => 'EcompetenceBundle:Optiondiplome',
                   // 'attr' => array('class'=>'selectpicker','data-live-search'=>true),
                    'property' => 'libOption',
                    'required' => false,
                    'label'=>'Option de la spécialité'
                ])
                ->add('sexe', 'entity', [
                    'class' => 'AgentBundle:Sexe',
                  //  'attr' => array('class'=>'selectpicker','data-live-search'=>true),
                    'property' => 'libSexe',
                    'required' => false,
                ])
                
        
        ;
    }

    public function getName() {
        return 'comptence_ecompetencebundle_rechercher';
    }

}
