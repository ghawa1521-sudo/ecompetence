<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class NewsUpdateType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $etat = array(
            'URGENT' => 'URGENT',
            'INFO' => 'INFO'
        );
        $builder
                // ->add('datecreation')
                ->add('debut', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => false,
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('fin', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => false,
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('nature', 'choice', array('label' => 'Type de News', 'choices' => $etat,
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true))
                ->add('msg')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\News'
        ));
    }

}
