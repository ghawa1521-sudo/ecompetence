<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiplomeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libDiplome')
            ->add('niveau')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Diplome',
            'attr'=>['id'=>'form_body_diplo'],
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecompetence_ecompetencebundle_diplome';
    }
}
