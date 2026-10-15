<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class Agent_LangueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $Niveaulangue= array(
        
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",      
         );
         $typelang= array(
            "International" => "International",
            "National"=>"National",
            "Local"=>"Local",
         ); 

        $builder
                
            ->add('langue',EntityType::class,[
                'class' => 'EcompetenceBundle:Langue',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')
                    ->orderBy('d.liblangue', 'ASC');
                },
                'empty_value' => '---- Choisir la langue ----',
                    'attr' => array('required' => false,'names'=>'jj')])
                    
            ->add('typelang', 'Choice',array(
                        'empty_value' => '---- Choisir type de langue ----',
                        'choices' =>  $typelang,
                        'expanded' => false,
                        'multiple' => false,
                        'label' => '',
                        'attr' => array('required' => false)))
                       
                   
               
            ->add('lire','choice', array(
                    'empty_value' => '---- Choisir niveau ----',
                    'choices' => $Niveaulangue,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => '',
                   'attr' => array('required' => false)))
            ->add('ecrire','choice', array(
                    'empty_value' => '---- Choisir le niveau ----',
                    'choices' => $Niveaulangue,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => '',
                    'attr' => array('required' => false)))
            ->add('parler','choice', array(
                    'empty_value' => '---- Choisir le niveau ----',
                    'choices' => $Niveaulangue,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => '',
                    'attr' => array('required' => false)))
            
            ->add('agent')
            ->add('enregistrer', 'submit', array('label' => '+  Enrégistrer le niveau de langue'))      
           

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Agent_Langue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecompetence_ecompetencebundle_agent_langue';
    }
}
