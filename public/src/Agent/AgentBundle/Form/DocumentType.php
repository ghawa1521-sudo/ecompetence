<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\securityContext;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */


  

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')

            ->add('docFile', 'vich_file' , array(
                        'label'         => ' ',
                         'attr' => ['accept'=>".pdf"],
                        'required'      => true,
                        'allow_delete'  => true, // not mandatory, default is true
                        'download_link' => true, // not mandatory, default is true
                        //'upload_max_size_message' => 'Veuillez choisir un fichier dont la taille n \' excède 2M '
                        ))
            ->add('Matricule', NULL ,array('attr' => array('style'=>'pointer-events:none;')
                                           ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agent\AgentBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agent_agentbundle_document';
    }
}
