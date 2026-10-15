<?php

namespace PasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use PasBundle\Form\ActionsType;
class ObjectifsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('libelleobj')
            ///->add('datecreation')
            //->add('axes')
              ->add('actions', CollectionType::class, array(
            'entry_type' => ActionsType::class,
            'entry_options' => array('label' => false),
        ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PasBundle\Entity\Objectifs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pasbundle_objectifs';
    }
}
