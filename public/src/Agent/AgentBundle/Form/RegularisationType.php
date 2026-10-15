<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Entity\Document;
use Doctrine\ORM\EntityRepository;

class RegularisationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id=$options['id'];
        if ($id == 1 or $id ==2)
        {
        $builder
            
            ->add('agent', NULL, ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => 'Choisir l\'agent',
                    'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:Agent',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('a')
                                ->orderBy('a.nom, a.prenoms', 'ASC')
                        ;
                    }])
            
            //->add('dateOld')
            
            ->add('pj',new DocumentType(),['label' => false,
                            'attr' => array('required' => true)])
            ->add('pjJustificatif',new DocumentType(),['label' => false,
                            'attr' => array('required' => true)])
            ->add('numNote',null, ['label'=>'Numéro certificat de prise de service DGE antérieur'])
            
            ->add('dateNumNote', 'datetime', array('label' => 'Date certificat de prise de service DGE antérieur', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')))

            //->add('etatModif')
            //->add('dateModif')
            //->add('matAgentModif')
            //->add('pjNumerise')
            //->add('dateSigneNew')
           // ->add('dateNumeriseAutoNew')
           // ->add('matAgentNumerise')
        ;
        if ($id == 1){
            $builder->add('new','entity', ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir le nouvel emploi'], 'label' => 'Choisir le nouvel emploi',
                    //'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:emploi',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('e')
                                ->orderBy('e.libEmpl', 'ASC')
                        ;
                    }])->add('dateNew', 'datetime', array('label' => 'Date du nouvel emploi', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')));
        }elseif($id == 2){
             $builder->add('new','entity', ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir la nouvelle fonction'], 'label' => 'Choisir la nouvelle fonction',
                    //'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:Fonction',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('f')
                                ->orderBy('f.libFonc', 'ASC')
                        ;
                    }])->add('dateNew', 'datetime', array('label' => 'Date de la nouvelle fonction', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')))

                    ->add('code_dg',null, ['required'=>true,'label' => 'Direction Générale', 'placeholder' => '--- Direction Générale ---',
                            'attr' => ['data-display' => 'Select', 'class' => 'code_dg'],
                           /* 'class' => 'AgentBundle:DirectionGenerale',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d');
                            },*/
                            'choice_attr' => function ($code_dg, $key, $value) {
                                return ['data-chained' => ($code_dg->getcodeDg()),
                                ];
                            },
                        ])
                    ->add('code_dc',null, ['required'=>true,'label' => 'Direction', 'placeholder' => '--- Choisir la direction ---',
                            'attr' => ['data-display' => 'Select', 'class' => 'code_dc'],
                           /* 'class' => 'AgentBundle:Direction',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d')->where('d.code_dg = :CODE_DG')
                                        ->setParameter('CODE_DG', $this->dir);
                            },*/
                            'choice_attr' => function ($code_dc, $key, $value) {
                                return ['data-chained' => ($code_dc->getDirectionGle()->getCodeDg()),
                                ];
                            },
                        ])
                    ->add('code_sd', null, ['label' => 'Sous direction', 'placeholder' => '--- Choisir la sous-direction ---',
                            'attr' => ['data-display' => 'Select', 'class' => 'code_sd'],
                           /* 'class' => 'AgentBundle:SousDirection',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d')->where('d.code_dc = :CODE_DC')
                                        ->setParameter('CODE_DC', $this->dir);
                            },*/
                            'choice_attr' => function ($code_sd, $key, $value) {
                                return ['data-chained' => ($code_sd->getCodeDc()->getId()),
                                ];
                            },
                        ])
                        ->add('code_sc', null, ['label' => 'Service', 'placeholder' => '--- Choisir le service ---',
                            'attr' => ['data-display' => 'Select', 'class' => 'code_sc'],
                            'choice_attr' => function ($code_sc, $key, $value) {
                                return ['data-chained' => ($code_sc->getCodeSousDir()->getCodeSd()),
                                ];
                            },
                ])
                    ;
        }
    }elseif($id==3){
        $builder
            
            ->add('agent', NULL, ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => 'Choisir l\'agent',
                    'choice_label' => 'concatNom',
                    'group_by' =>'Direction',
                    'class' => 'AgentBundle:Agent',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('a')->where('a.Type = 2')
                                ->orderBy('a.nom, a.prenoms', 'ASC')
                        ;
                    }])
            ->add('new','entity', ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir le nouvel emploi'], 'label' => 'Choisir le nouvel emploi',
                    //'choice_label' => 'concatNom',
                    'class' => 'AgentBundle:emploi',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('e')
                                ->orderBy('e.libEmpl', 'ASC')
                        ;
                    }])
            ->add('dateNew', 'datetime', array('label' => 'Date de prise de service', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('justificaton', null, array('label' => 'numero de candidature','required' => true,
                'attr' => array('class' => '')))
            ->add('pj',new DocumentType(),['label' => false,
                            'attr' => array('required' => true)])
            ->add('numNote',null, ['label'=>'Numéro note de service'])
            
            ->add('dateNumNote', 'datetime', array('label' => 'Date signature note de service', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')));
    }
}
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Regularisation',
            'id'=>1,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent_agentbundle_regularisation';
    }
}
