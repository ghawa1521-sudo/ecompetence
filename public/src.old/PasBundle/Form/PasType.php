<?php

namespace PasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use PasBundle\Form\AxesType;
class PasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('datecreation')
            //->add('exercice')
            //->add('direction')
            //->add('naturepas')
            ->add('axes', CollectionType::class, array(
            'entry_type' => AxesType::class,
            'entry_options' => array('label' => false),
        ));

        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PasBundle\Entity\Pas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pasbundle_pas';
    }
}
