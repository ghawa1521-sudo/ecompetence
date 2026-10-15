<?php

namespace Demandes\DemandesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\securityContext;
use Demandes\DemandesBundle\TypeDemande;

class DemandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */


    private $securityContext;
    private $todo;

    public function __construct(SecurityContext $securityContext,$todo)
    {
        $this->securityContext = $securityContext;
        $this->todo = $todo;

        //var_dump($this->todo);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        switch ($this->todo) {


            case 0:
                 $builder
                ->add('typeDemande');
                break;


            case 1:

        $builder
            ->add('typeDemande',NULL,[
                  'label'=>'Type de la Demande',
                  'attr'=>['class'=>'pointer-css-invisible'],
                  'class'=>'DemandesBundle:TypeDemande',
                  'query_builder'=>function(EntityRepository $er) {
                  $querybuilder = $er->findTypeDemandePrive();
                  return $querybuilder;
                  },
                  'empty_value' => '-- Sélectionner le type de la Demande --',])
            ->add('dateDeb','datetime', array('label'=>'Date de Début' , 'widget' => 'single_text','format' => 'dd-MM-yyyy' ,'date_format' => 'dd-MM-yyyy H:i',
                'attr' => array('class' => 'form-control datetimepicker')))

            ->add('dateFin','datetime', array('label'=>'Date de Fin','widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i',
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('objet',NULL,['label'=>'Motif de la demande'])
            ->add('destination')
        ;
        break;
        //affichage du motif de rejet avec la valeur $todo=99
        case 99:

            $builder
            ->add('motifRejet',NULL,array('label' => ' '));
        break;

        default:

        $builder
            ->add('typeDemande', NULL,
            [
            'class'=>'DemandesBundle:TypeDemande',
            'query_builder'=>function(EntityRepository $er) {
            $querybuilder = $er->findTypeDemandePrive($this->todo);
            return $querybuilder;
            },
            'empty_value' => '-- Sélectionner le type de la Demande --',])
            //->add('datecreation','datetime', array('widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i',
                //'attr' => array('class' => 'form-control datetimepicker')))

            //->add('dateDeb','datetime', array('widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i',
                //'attr' => array('class' => 'form-control datetimepicker')))

            //->add('dateFin','datetime', array('widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i',
                //'attr' => array('class' => 'form-control datetimepicker')))

            //->add('emmeteur')

            ->add('objet')
            //->add('destination')

            /*
            ->add('etatEmmission')
            ->add('SupDir')
            ->add('dateRepSupDir','datetime', array('widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i',
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('etatRepSupDir')
            ->add('Grh')
            ->add('dateRepGrh','datetime', array('widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i',
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('etatRepGrh')*/
        ;

        break;
    }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Demandes\DemandesBundle\Entity\Demande'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'demandes_demandesbundle_demande';
    }
}
