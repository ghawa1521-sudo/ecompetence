<?php

namespace Ediligence\EdiligenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Agent\AgentBundle\Form\PjRType;


class RejetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('librejet', TextareaType::class, array('attr' => array('class' => 'textarea-editor', 'rows' => '5')))
            ->add('pjrejet', new PjRType(), ['required' => false]);
            //->add('imputdir', null,array('attr' => array('style' => 'display:none;')));
    }
    //$form->add('idImput',  HiddenType::class, array('data'=>$id));
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ediligence\EdiligenceBundle\Entity\Tmp_traitement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ediligence_ediligencebundle_tmp_traitement';
    }
}
