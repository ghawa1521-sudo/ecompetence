<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Entity\Agent;
use Agent\AgentBundle\Entity\Document;

class AffecterNumeriseType extends AbstractType {

    private $entity;
    private $user;
    private $deleguation;
    public function __construct($entity = null, $user = null, $deleguation=2) {
        $this->entity = $entity;
        $this->user = $user;
        $this->deleguation = $deleguation;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        if (($this->user->hasRole('ROLE_RESPO') and $this->entity->getEtatAffectation() == 1 and $this->entity->getsigneNote() == 1)
          or ($this->deleguation == 0 and $this->entity->getEtatAffectation() == 1 and $this->entity->getsigneNote() == 1)) {
            $builder->add('dateprise', 'datetime', array('label' => ' ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')));
        }elseif (($this->user->hasRole('ROLE_RESPO_SRHMG') and $this->entity->getEtatAffectation() == 1)
          or ($this->deleguation == 0 and $this->entity->getEtatAffectation() == 1)) {
            $builder->add('dateNote', 'datetime', array('label' => ' ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                        'attr' => array('class' => 'form-control datetimepicker')))
                    ->add('documentNote', new DocumentType())
                    ->add('numNote', null, ['label' => ' ', 'required' => true,'data'=>'/MEF/DGE/SRHMG']);
        }elseif (($this->user->hasRole('ROLE_RESPO_SRHMG') and $this->entity->getEtatAffectation() == 2)
        or ($this->deleguation == 0 and $this->entity->getEtatAffectation() == 2)) {
            $builder->add('dateCertificat', 'datetime', array('label' => ' ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                        'attr' => array('class' => 'form-control datetimepicker')))
                    ->add('documentCertif', new DocumentType())
                    ->add('numCertificat', null, ['label' => ' ', 'required' => true, 'data'=>'/MEF/DGE/SRHMG']);
        }
        

        # {% if is_granted('ROLE_RESPO') and entity.etatAffectation == 1 and entity.signeNote == 1 %}
        //->add('dateMiseService', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => false,
        //'attr' => array('class' => 'form-control datetimepicker')))
        /* >add('dateNote', 'datetime', array('label' => ' ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
          'attr' => array('class' => 'form-control datetimepicker')))
          ->add('dateprise', 'datetime', array('label' => ' ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
          'attr' => array('class' => 'form-control datetimepicker')))
          ->add('dateCertificat', 'datetime', array('label' => ' ', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
          'attr' => array('class' => 'form-control datetimepicker'))); */
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Affecter'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'agent_agentbundle_affecter';
    }

}
