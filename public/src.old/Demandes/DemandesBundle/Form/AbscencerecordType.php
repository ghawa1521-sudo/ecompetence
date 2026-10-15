<?php

namespace Demandes\DemandesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Demandes\DemandesBundle\TypeDemande;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Form\PjRType;

class AbscencerecordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

     private $matricule;
     private $superieur;

     public function __construct($matricule, $superieur)
     {
         $this->matricule = $matricule;
         $this->superieur = $superieur;
     }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $agent = $this->matricule;
        $superieur = $this->superieur['sup1'];
        
        $builder
            ->add('typeDemande', NULL,[
              'attr' => array('required' => true),
            'class'=>'DemandesBundle:TypeDemande',
            'query_builder'=>function(EntityRepository $er) {
            $querybuilder = $er->findTypeDemandePublic();
            return $querybuilder;
            },
            'empty_value' => '-- Sélectionner le type de la Demande --',
            ])
          ->add('dateDeb','datetime', array('required' => false,'label'=>'Date de Début' , 'widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i','format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('dateFin','datetime', array('required' => false,'label'=>'Date de Fin','widget' => 'single_text', 'date_format' => 'dd-MM-yyyy H:i','format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('objet',NULL,['required' => true,'label'=>'Motif de la demande'])
            ->add('piecejointe', new PjRType(), ['required' => true])
            ->add('emmeteur', NULL, ['attr' => [
                                    'style' => 'color:green',
                                    'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => 'Choisir agent',
                                'choice_label' => 'concatNommatricule',
                                'class' => 'AgentBundle:Agent',
                                'group_by'=>'Direction',
                                'query_builder' => function(EntityRepository $repo) use ($agent, $superieur) {
                                   $respo = $repo->createQueryBuilder('a')
                                         ->where($agent->getAgent()->getServiceActuelWhere('a','serv'))
                                         ->setParameter('serv',$agent->getAgent()->getServiceActuel()) ; 
                                   if($agent->hasRole('ROLE_SAAF')) {
                                    $respo = $respo->andWhere('a.id <>:chef')
                                                   ->setParameter('chef',$superieur->getId());
                                   }else{
                                        $respo = $respo->andWhere('a.Fonction <:id')
                                                       ->setParameter('id',$agent->getAgent()->getFonction()->getId());
                                   }

                                    $respo = $respo->orderBy('a.nom, a.prenoms', 'ASC');
                                              
                                return $respo;
                                }])
            ->add('submit', 'submit', array('label' => 'Enregistrer la Demande', 'attr' => array('class' => 'btn-success col-md-push-4 col-md-4 col-lg-4 col-sm-4')))
        ;
        
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
