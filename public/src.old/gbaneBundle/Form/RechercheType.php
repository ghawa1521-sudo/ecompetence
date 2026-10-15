<?php

namespace gbaneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RechercheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              /* ->add('agent','entity', [
                   'attr'=>['class'=>'champagent selectpicker','onChange'=>'champ(this)', 'data-live-search' => 'true'],
                   'class' => 'AgentBundle:Agent',
                   'mapped'=>false,
                   'required'=>false,
                   'choice_label' => 'concatNommatricule', 
                   'placeholder' => 'choisir un agent',
                   'query_builder' => function(\Doctrine\ORM\EntityRepository $respo){
                   return $respo->createQueryBuilder('a')
                           ->Where('a.FonctionAssimilees is not null')
                          ;
                   }]) */
              // ->add('fonction','entity',['class' => 'AppBundle:Fonction','choice_label' =>'libFocnt', 'placeholder' =>'choisir une fonction']) 
               ->add('fonctionassimilees','entity',['attr'=>['class'=>'champautres','onchange'=>'champ(this)'],'label'=>'Fonction assimilee','class' => 'gbaneBundle:FonctionAssimilees','choice_label' =>'libFonctAss','required'=>false, 'placeholder' =>'choisir une fonction assimilee']) 
               //->add('ancienneteGrade',null,array('label'=>'anciennete Grade :'))
               //->add('ancienneteDge',null,array('label'=>'anciennete Dge :')) 
               ->add('grade','entity',['attr'=>['class'=>'champautres','onchange'=>'champ(this)'],'class' => 'AgentBundle:Grade','choice_label' =>'libGrade','required'=>false, 'placeholder' =>'choisir un grade']) 
               ->add('ancienneteGrade',null,array('attr'=>['class'=>'champautres','onchange'=>'champ(this)'],'label'=>'Anciennete Grade :','required'=>false))
               ->add('ancienneteDge',null,array('attr'=>['class'=>'champautres','onchange'=>'champ(this)'],'label'=>'Anciennete Dge :','required'=>false))            
               /* ->add('Fonction_Assimilee', choiceType::class, array(
               'choices' => array('Chef de Bureau et Assimilés','	
Chef de Service et Assimilés','Sous-Directeur d\'Administration et Assimilés','Directeur Régional et Assimilés',
        'Directeur D\'Administration Centrale et Assimilés','Directeur Général Adjoint et Assimilés',
        'Directeur Général et Assimilés')))
                ->add('Agent','entity', array('class' => 'AppBundle:Agent','property' => 'matricule', 'empty_value' => '', 'required' => FALSE))
                
                ->add('Fonctions_et_Assimilees','entity', array('class' => 'AppBundle:FonctionAssimilees', 'property' => 'libFonctAss','empty_value' =>'Fonctions et assimilees','required' => FALSE))
       
               
                ->add('Grade','entity', array('class' => 'AppBundle:Grade', 'property' => 'libGrad','empty_value' =>'Grade','required' => FALSE))
                
                ->add('ancienneteGrade',null,array('label'=>'anciennete Grade :'))
                
                ->add('ancienneteDge',null,array('label'=>'anciennete Dge :'))
              */
                ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gbaneBundle\Entity\Regles'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gbanebundle_regles';
    }


}
