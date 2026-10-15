<?php

namespace Demandes\DemandesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class QuotaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('typeDemande',NULL,[
                'class'=>'DemandesBundle:TypeDemande',
                'query_builder'=>function(EntityRepository $er) {
                $querybuilder = $er->findTypeDemande();
                return $querybuilder;
                },
                'empty_value' => '-- Sélectionner le type de la Demande --',
                ])
            ->add('periode')
            ->add('nbreQuota',NULL,['label'=>'Nombre de Demande Autorisé'])
            ->add('nbreJoursAvant',NULL,['label'=>'Délai Avant la Demande'])
            //->add('nbreJoursApres')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Demandes\DemandesBundle\Entity\Quota'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'demandes_demandesbundle_quota';
    }
}
