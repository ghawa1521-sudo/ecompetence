<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Entity\Document;
use Doctrine\ORM\EntityRepository;

class DetachementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id=$options['id']; $modif=$options['modif']; 

        $builder
            ->add('agent', NULL, ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => 'Choisir l\'agent',
                    'choice_label' => 'concatNommatricule',
                    'class' => 'AgentBundle:Agent',
                    'query_builder' => function(EntityRepository $repo) use ($id, $modif) {
                        $respo = $repo->createQueryBuilder('a');
                        if($modif > 0){
                        $respo = $respo->leftjoin('AgentBundle:Detachement', 'e','WITH', 'a.id = e.agent')
                                       ->Where("(a.position is null and e.agent is null) Or (e.agent is not null and e.id = ".$modif.")");
                        }else{
                        $respo = $respo->Where('a.position  is null');
                        }
                                    
                        $respo = $respo->orderBy('a.nom, a.prenoms', 'ASC');

                        return $respo;
                        
                    }])
            
            ->add('pj',new DocumentType(),['label' => false,
                            'attr' => array('required' => true)])

            ->add('numNote',null, ['label'=>'Numéro de la note', 'attr' => array('required' => true)])
            
            ->add('dateNumNote', 'datetime', array('label' => 'Date de la note', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('dateDetachement', 'datetime', array('label' => 'Date effective de cessation', 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'required' => true,
                'attr' => array('class' => 'form-control datetimepicker')))
            ->add('objetnote',NULL,['label'=>'Motif du detachement', 'attr' => array('required' => true)]);

            if($id==1){

            $builder->add('Provenance','entity', ['attr' => [
                        'required'=>true,
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir la nouvelle destination'], 'label' => 'Choisir la nouvelle destination',
                    'class' => 'AgentBundle:provenance',
                    'query_builder' => function(EntityRepository $repo) {
                        return $repo->createQueryBuilder('e')
                                ->orderBy('e.ministere', 'ASC')
                        ;
                    }]) ;
          
       
       }
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Detachement',
            'id'=>1,
            'modif'=>0,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent_agentbundle_detachement';
    }
}
