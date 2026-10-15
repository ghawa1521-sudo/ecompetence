<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Agent\AgentBundle\Form\AffecterType;

class CongesResearchType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //die;
        $builder
            ->add('agent', 'entity', [
                'label' => 'Saisir le matricule',
                'class' => 'UsersBundle:Users',
                'property' => 'username',
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'
                ], 'label' => 'rechercher l\'agent',
                'choice_label' => 'concatNom',
                'class' => 'AgentBundle:Agent',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('a')
                        ->orderBy('a.nom, a.prenoms', 'ASC');
                }
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'Agent\AgentBundle\Entity\Agent',
            'validation_groups' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'conges_research_form';
    }
}
