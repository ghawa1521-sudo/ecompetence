<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class DesignationType extends AbstractType {

    private $tableau;

    public
            function __construct($tableau = null) {
        $this->tableau = $tableau;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public
            function buildForm(FormBuilderInterface $builder, array $options) {

        foreach ($this->tableau as $directiongle => $value) {
            //dump($value['Service']->getCodeDg());

            if (preg_match("#DG#", $directiongle)) {
                $nameDG = '_' . $value['Service']->getCodeDg();
                $respo = (empty($value['respo'])) ? 'null' : '_' . $value['respo']->getId();

                $respoobjet = (empty($value['respo'])) ? 'null' : $value['respo'];
                $respoName = (empty($value['respo'])) ? 'NON DEFINI' : '' . $value['respo']->concatNom();

                $name = $nameDG . $respo;
                $builder
                        ->add($name . "_Service", TextType::class, ['required' => false, 'label' => $value['Service']])
                        ->add($name . "_label", TextType::class, ['required' => false, 'label' => $respoName])
                        ->add($name, 'entity', ['class' => 'AgentBundle:Agent', 'required' => false, 'label' => 'Liste des agents', 'empty_value' => '---- Choisir un agent ----',
                            'attr' => ['class' => 'selectpicker', 'data-live-search' => 'true', 'title' => '---Choisir un agent---'],
                            'choice_label' => 'concatNom',
                            'query_builder' => function(EntityRepository $er) use ($respoobjet) {

                                $querybuilder = $er->designerliste($respoobjet);
                                return $querybuilder;
                            }])
                        ->add($name . '_submit', 'submit', array('label' => 'DESIGNER'));
            }

            foreach ($value as $direction => $value1) {
                if (preg_match("#DC#", $direction)) {
                    $nameDC = '_' . $value1['Service']->getCodeDc();
                    $respo = (empty($value1['respo'])) ? '_null' : '_' . $value1['respo']->getId();
                    $respoName = (empty($value1['respo'])) ? 'NON DEFINI' : '' . $value1['respo']->concatNom();
                    $respoobjet = (empty($value1['respo'])) ? 'null' : $value1['respo'];
                    $name = $nameDG . $nameDC . $respo;
                    $builder
                            ->add($name . "_Service", TextType::class, ['required' => false, 'label' => $value1['Service']])
                            ->add($name . "_label", TextType::class, ['required' => false, 'label' => $respoName])
                            ->add($name, 'entity', ['class' => 'AgentBundle:Agent', 'required' => false, 'label' => 'Liste des agents', 'empty_value' => '---- Choisir un agent ----',
                                'attr' => ['class' => 'selectpicker', 'data-live-search' => 'true', 'title' => '---Choisir un agent---'], 'choice_label' => 'concatNom',
                                'query_builder' => function(EntityRepository $er) use ($respoobjet) {

                                    $querybuilder = $er->designerliste($respoobjet);
                                    return $querybuilder;
                                }])
                            ->add($name . '_submit', 'submit', array('label' => 'DESIGNER'));
                }

                foreach ($value1 as $sousdirection => $value2) {
                    if (preg_match("#SD#", $sousdirection)) {
                        $nameSD = '_' . $value2['Service']->getCodeSd();
                        $respo = (empty($value2['respo'])) ? '_null' : '_' . $value2['respo']->getId();
                        $respoName = (empty($value2['respo'])) ? 'NON DEFINI' : '' . $value2['respo']->concatNom();
                        $name = $nameDG . $nameDC . $nameSD . $respo;
                        $respoobjet = (empty($value2['respo'])) ? 'null' : $value2['respo'];
                        $builder
                                ->add($name . "_Service", TextType::class, ['required' => false, 'label' => $value2['Service']])
                                ->add($name . "_label", TextType::class, ['required' => false, 'label' => $respoName])
                                ->add($name, 'entity', ['class' => 'AgentBundle:Agent', 'required' => false, 'label' => 'Liste des agents', 'empty_value' => '---- Choisir un agent ----',
                                    'attr' => ['class' => 'selectpicker', 'data-live-search' => 'true', 'title' => '---Choisir un agent---'], 'choice_label' => 'concatNom',
                                    'query_builder' => function(EntityRepository $er) use ($respoobjet) {

                                        $querybuilder = $er->designerliste($respoobjet);
                                        return $querybuilder;
                                    }])
                                ->add($name . '_submit', 'submit', array('label' => 'DESIGNER'));


                        foreach ($value2 as $servicedirection => $value3) {
                            if (preg_match("#SC#", $servicedirection)) {
                                $nameSC = '_' . $value3['Service']->getCodeSc();
                                $respo = (empty($value3['respo'])) ? '_null' : '_' . $value3['respo']->getId();
                                $respoName = (empty($value3['respo'])) ? 'NON DEFINI' : '' . $value3['respo']->concatNom();
                                $name = $nameDG . $nameDC . $nameSD . $nameSC . $respo;
                                $respoobjet = (empty($value3['respo'])) ? 'null' : $value3['respo'];
                                $builder
                                        ->add($name . "_Service", TextType::class, ['required' => false, 'label' => $value3['Service']])
                                        ->add($name . "_label", TextType::class, ['required' => false, 'label' => $respoName])
                                        ->add($name, 'entity', ['class' => 'AgentBundle:Agent', 'required' => false, 'label' => 'Liste des agents', 'empty_value' => '---- Choisir un agent ----',
                                            'attr' => ['class' => 'selectpicker', 'data-live-search' => 'true', 'title' => '---Choisir un agent---'], 'choice_label' => 'concatNom',
                                            'query_builder' => function(EntityRepository $er) use ($respoobjet) {

                                                $querybuilder = $er->designerliste($respoobjet);
                                                return $querybuilder;
                                            }])
                                        ->add($name . '_submit', 'submit', array('label' => 'DESIGNER'));
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @return string
     */
    public
            function getName() {
        return 'agent_agentbundle_designation';
    }

}
