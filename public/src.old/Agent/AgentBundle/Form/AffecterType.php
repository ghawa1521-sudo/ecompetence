<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Entity\Agent;
use Agent\AgentBundle\Entity\Document;
class AffecterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    private $todo;
    public function __construct($todo, $saaf=null, $dir=null)
    {
        $this->todo = $todo;
        $this->saaf = $saaf;
        $this->dir = $dir;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /*  ->add('numero','text',['label' => 'Matricule'])

          ->add('SituationAffectation',NULL,['label' => 'Situation Matrimoniale','attr'=>['onChange'=>'activeBis()']])

*/      

          if ($this->saaf == 1){
          $builder->add('agent',  new AgentType($this->todo, $this->dir));
        }else{

        if ($this->todo > 2){
            $builder->add('document', new DocumentType(null,null));
        }else{
          
            $builder->add('agent',  new AgentType($this->todo));
        }
}



    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Affecter',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent_agentbundle_affecter';
    }
}
