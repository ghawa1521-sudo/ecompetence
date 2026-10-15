<?php

namespace Demandes\DemandesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints as Assert;

class rechercheStatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut','datetime', array('label'=>'Date de Début' , 'widget' => 'single_text','format' => 'dd-MM-yyyy' ,'date_format' => 'dd-MM-yyyy H:i',
                'attr' => array('class' => 'form-control datetimepicker','placeholder'=>'Date de début')))
            ->add('fin','datetime', array('label'=>'Date de Fin' , 'widget' => 'single_text','format' => 'dd-MM-yyyy' ,'date_format' => 'dd-MM-yyyy H:i',
                'attr' => array('class' => 'form-control datetimepicker','placeholder'=>'Date de début')))
            ->add('rechercher','submit',['attr'=>['class'=>'btn btn-success']])
        ;
    }
   
/**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
     $resolver->setDefaults([
        'constraints' => [
            new Assert\Expression([
                'expression' => 'value["debut"] <= value["fin"]',
                'message' => 'la date de début ne peut-être ultérieure à la date de fin'
            ]),
            
            
        ],
    ]);
}
    /**
     * @return string
     */
    public function getName()
    {
        return 'demande_statistique_rechercher';
    }
}
