<?php

namespace Ediligence\EdiligenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Agent\AgentBundle\Form\PjRType;


class TarchiveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('obsrv', TextareaType::class, array('required'=>true,'attr' => array('class' => 'textarea-editor', 'rows' => '5')))
            ->add('nomFichier', new PjRType(), ['required' => false]);
           
    }
    //$form->add('idImput',  HiddenType::class, array('data'=>$id));
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ediligence\EdiligenceBundle\Entity\Tarchive'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ediligence_ediligencebundle_Tarchive';
    }
}
