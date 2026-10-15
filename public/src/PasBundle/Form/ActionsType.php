<?php

namespace PasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Agent\AgentBundle\Form\PjType;
class ActionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('libelleaction')
            //->add('datecreation')
            //->add('calendar')
            //->add('criterenote')
            //->add('objectifs')
            //->add('indicateurs')
            //->add('budget')
            //->add('partenaires')
            //->add('resultats')
            //->add('sources')
            ->add('piecejointe', new PjType());

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PasBundle\Entity\Actions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pasbundle_actions';
    }
}
