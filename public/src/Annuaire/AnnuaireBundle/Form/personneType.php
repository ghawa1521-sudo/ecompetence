<?php

namespace Annuaire\AnnuaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class personneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenoms')
            ->add('pays')
            ->add('ville')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Annuaire\AnnuaireBundle\Entity\personne'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'annuaire_annuairebundle_personne';
    }
}
