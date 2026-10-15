<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Agent\AgentBundle\Form\AffecterType;

class AgentRechercheType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        //die;
     
       
        $builder
                //->add('matricule')
                //->add('Lieu_Naissance',NULL,['label' => 'Lieu de Naissance'])
                /* ->add('cvFile', 'vich_file' , array(
                  'label' => 'Choisir un CV',
                  'attr' => ['accept'=>".pdf", 'label'=>'Choisir un CV'],
                  'required'      => false,
                  'allow_delete'  => true, // not mandatory, default is true
                  'download_link' => true, // not mandatory, default is true
                  )) */
               // ->add('matricule', 'text', [
                  //  'required' => false,
              //  ])
             
          
        //->add('telUrgent1')
        //->add('telUrgent2')
        //->add('Lieu_Naissance')
        //->add('telBur')
        //->add('telDom')
        ;
    }

    /**
      /* @param OptionsResolverInterface $resolver
      /**** */
    /*
      public function setDefaultOptions(OptionsResolverInterface $resolver)
      {
      $resolver->setDefaults(array(
      'data_class' => 'Agent\AgentBundle\Entity\Agent'
      ));
      } */

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_rechercheragent';
    }

}
