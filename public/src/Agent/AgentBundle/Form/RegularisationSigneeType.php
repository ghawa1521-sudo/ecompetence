<?php

namespace Agent\AgentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Entity\Document;
use Doctrine\ORM\EntityRepository;

class RegularisationSigneeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pjNumerise', new DocumentType(), [
                'label' => false
            ])
            ->add('dateSigneNew', 'datetime', [
                'label' => 'Date de signature de la note',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'required' => true,
                'attr' => [
                    'class' => 'form-control datetimepicker',
                    'style' => 'width:200px;'
                ]
            ]);
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Agent\AgentBundle\Entity\Regularisation',
        ]);
    }

    public function getName()
    {
        return 'regularisation_signee';
    }
}