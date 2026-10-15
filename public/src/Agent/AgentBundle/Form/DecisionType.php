<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Agent\AgentBundle\Form\PjRType;
use Doctrine\ORM\EntityRepository;

class DecisionType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'datetime', array('label' => 'Date ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i',
                    'attr' => array('class' => 'form-control datetimepicker')))
                ->add('numero', null, ['required' => true, 'label' => 'Numero décision'])
                /* ->add('exercice', null, ['required' => true])

                 */
                ->add('exercice', null, [
                    'attr' => array('required' => false, 'class' => ''),
                    'empty_value' => '-- Choisir l\'exercice --',
                    //'property' => 'nomSite',
                    'multiple' => FALSE,
                    'class' => 'AgentBundle:Exercice',
                    'query_builder' => function(EntityRepository $er) {
                        //  $querybuilder = $er->createQueryBuilder('ex'); //Retrouver les de l'agent
                        return $er->createQueryBuilder('ex')
                                ->where('ex.annee =:an')
                                ->setParameter('an', (intval(date('Y')) - 1));
                    }
                ])
                ->add('direction', null, ['required' => false,
                    'label' => 'Direction/ Service Rattaché / Cellule',
                    'empty_value' => '-- Choisissez --'])
                ->add('pj', new PjRType(), [
                    'required' => true])

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Decision'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_decision';
    }

}
