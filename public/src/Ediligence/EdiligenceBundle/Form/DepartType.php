<?php

namespace Ediligence\EdiligenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Agent\AgentBundle\Form\PjType;
use Doctrine\ORM\EntityRepository;

class DepartType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    /*  private $users;

      public function __construct($users=null) {
      $this->users=$users;
      } */
    private $enregistrement;

    public function __construct($enregistrement = null) {
        $this->enregistrement = $enregistrement;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if ($this->enregistrement == 0 || $this->enregistrement == null) {
            $label = 'Numero D\'enregistrement:';
        } else {
            $label = 'Numero D\'enregistrement: ' . $this->enregistrement;
        }

        $builder
                //->add('typecourrier','entity', ['attr'=>array('class'=>'typecourrier'), 'label' => 'Nature du courrier:', 'required' => true, 'class'=>'EdiligenceBundle:Ttypecourrier', 'choice_label'=> 'Libcourrier'])   
                //->add('sourceCour','entity', ['label' => 'Provenance du courrier:', 'required' => true, 'class'=>'EdiligenceBundle:Tprovenance', 'choice_label'=> 'Lib', 'empty_value'=>'CHOISIR UNE PROVENANCE'])
                //->add('adresseenreg','entity', ['label' => 'Expéditeur du courrier:', 'required' => true, 'class'=>'EdiligenceBundle:Texpediteur', 'choice_label'=> 'Lib', 'empty_value'=>'CHOISIR UN EXPEDITEUR'])
                ->add('objet', TextareaType::class, array('attr' => array('class' => 'textarea-editor', 'rows' => '5')))
                //->add('reforigine', null, array('label'=>'Référence D\'origine:'))    
                /* ->add('dateorigine', DateType::class, array('widget' => 'single_text',
                  'label' => 'Date Origine:',
                  'format' => 'dd-MM-yyyy',
                  'attr' => array('class' => 'input-datepicker'))) */
                ->add('numenregistrements', null, array('label' => $label))
                ->add('observationscecour', TextareaType::class, array('attr' => array('required' => false, 'class' => 'textarea-editor', 'rows' => '5'), 'label' => 'Annotations Service courrier:'))
                ->add('piecejointe', new PjType(), ['required' => false])
                ->add('texterieur', 'entity', ['label' => 'Destinataire Extérieur:', 'required' => false, 'class' => 'EdiligenceBundle:Texterieur', 'choice_label' => 'Lib', 'empty_value' => 'CHOISIR UN DESTINATAIRE']);
        //   if($this->users->hasRole('ROLE_Service_Courrier')){
        //  $builder ->add('texterieur', 'entity', ['label' => 'Destinataire Extérieur:', 'required' => false, 'class' => 'EdiligenceBundle:Texterieur', 'choice_label' => 'Lib', 'empty_value' => 'CHOISIR UN DESTINATAIRE']);
        //  }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Ediligence\EdiligenceBundle\Entity\Tcourrier'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ediligence_ediligencebundle_tcourrier';
    }

}
