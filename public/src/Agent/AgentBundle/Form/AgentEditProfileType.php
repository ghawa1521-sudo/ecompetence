<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Form\AdresseType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Form\AffecterType;

class AgentEditProfileType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        //die;
        $builder
                //->add('matricule')
                ->add('Lieu_Naissance', NULL, ['label' => 'Lieu de Naissance', 'attr' => [
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir le lieu de Naissance']])
                ->add('cvFile', 'vich_file', array(
                    'label' => 'Choisir un CV',
                    'attr' => ['accept' => ".pdf", 'label' => 'Choisir un CV'],
                    'required' => false,
                    'allow_delete' => true, // not mandatory, default is true
                    'download_link' => true, // not mandatory, default is true
                ))
                ->add('imageFile', 'vich_file', array(
                    'label' => 'Choisir une photo de profil',
                    'label_attr' => ['value' => ' '],
                    'attr' => ['accept' => "image/*", 'label' => ' '],
                    'required' => false,
                    'allow_delete' => false, // not mandatory, default is true
                    'download_link' => true, // not mandatory, default is true
                ))
                ->add('telPort')
                ->add('quartier')
                ->add('persUrgent1')
                ->add('persUrgent2')
                ->add('telUrgent1')
                ->add('telUrgent2')
                ->add('emailPerso')
                ->add('adresse', CollectionType::class, array(
                    'entry_type' => AdresseType::class,
                    'entry_options' => array('label' => false),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ))
                ->add('telBur')
                ->add('telDom')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Agent'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_agent';
    }

}
