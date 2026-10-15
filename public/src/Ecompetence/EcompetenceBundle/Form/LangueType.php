<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class LangueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('liblangue', 'text', array('label' => 'Libellé de la langue'))
            ->add('TypeLangue', 'entity', array(
                'class' => 'EcompetenceBundle:TypeLangue',  // L'entité à utiliser
                'property' => 'libelle',                       // La propriété à afficher (par exemple "nom")
                'label' => 'Type de langue',
                'placeholder' => 'Choisissez un type de langue',
                'expanded' => false,  // Si vous voulez une liste déroulante
                'multiple' => false   // Une seule sélection possible
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Langue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecompetence_ecompetencebundle_langue';
    }
}
