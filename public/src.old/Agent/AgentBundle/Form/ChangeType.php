<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ChangeType extends AbstractType {

    private $users;

    public function __construct($users = null) {
        $this->users = $users;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
//verifier quil a un codesc
        if (!empty($this->users->getAgent()->getCodeSc())) {
//table sc
            $class = 'AgentBundle:ServiceDirection';
            $code = 's.code_sc =:codedc';
            $var = 'codedc';
            $val = $this->users->getAgent()->getCodeSc()->getCodeSc();
            $div = 'sc';
            $fonction = '';
            $champ = 'code_sc';
        } elseif (!empty($this->users->getAgent()->getCodeSd())) {
//table sc
            $class = 'AgentBundle:ServiceDirection';
            $code = 's.codeSousDir =:codedc';
            $var = 'codedc';
            $val = $this->users->getAgent()->getCodeSd()->getCodesd();
            $div = 'sd';
            $fonction = '';
            $champ = 'code_sc';
        } elseif (!empty($this->users->getAgent()->getCodeDc())) {
//table sd
            $class = 'AgentBundle:SousDirection';
            $code = 's.code_dc =:codedc';
            $var = 'codedc';
            $val = $this->users->getAgent()->getDirection()->getId();
            $div = 'dc';
            $fonction = 'searchList("#sd","affecter_serviceDirection_listetype","#sc", "#viewsc")';
            $champ = 'code_sd';
        } elseif (!empty($this->users->getAgent()->getCodeDg())) {
//table dc
            $class = 'AgentBundle:Direction';
            $code = 's.directionGle =:codedc';
            $var = 'codedc';
            $val = $this->users->getAgent()->getCodeDg()->getCodeDg();
            $div = 'dg';
            $fonction = 'searchList("#dc","affecter_sousDirection_listetype","#sd", "#viewsd")';
            $champ = 'dc';
        }


        $builder
                ->add('nivo', HiddenType::class, ['data' => $div])
                ->add($champ, 'entity', ['class' => $class,
                    'empty_value'=>'---- Choisir la Direction ----',
                    'attr' => array('onchange' => $fonction),
                    'query_builder' => function(EntityRepository $repo) use($code, $var, $val) {
                        return $repo->createQueryBuilder('s')
                                ->where($code)
                                ->setParameter($var, $val);
                    }]);

        if ($div == 'dg') {
            $builder->add('code_sd', 'entity', ['class' => 'AgentBundle:SousDirection', 'required'=>false, 'label' => 'Sous-Direction', 'empty_value' => '---- Choisir la Sous-Direction ----', 'attr' => array('onchange' => 'searchList("#sd","affecter_serviceDirection_listetype","#sc", "#viewsc")')])
                    ->add('code_sc', 'entity', ['class' => 'AgentBundle:ServiceDirection', 'required'=>false, 'label' => 'Service', 'empty_value' => '---- Choisir le Service ----']);
        } elseif ($div == 'dc') {
            $builder->add('code_sc', 'entity', ['class' => 'AgentBundle:ServiceDirection', 'required'=>false, 'label' => 'Service', 'empty_value' => '---- Choisir le Service ----']);
        }

        
    }

    /*

      public function setDefaultOptions(OptionsResolverInterface $resolver) {
      $resolver->setDefaults(array(
      'data_class' => 'Agent\AgentBundle\Entity\Agent'
      ));
      }

     */

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_change';
    }

}
