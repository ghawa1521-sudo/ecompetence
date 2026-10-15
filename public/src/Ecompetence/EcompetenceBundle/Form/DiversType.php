<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Ecompetence\EcompetenceBundle\Form\ConnaissanceInformatiqueType;
use Ecompetence\EcompetenceBundle\Form\DecorationType;

class DiversType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('connaissance', ConnaissanceInformatiqueType::class, [
                'required' => false,
                'csrf_protection' => false, // Important pour Symfony 2.8
            ])
            ->add('decoration', DecorationType::class, [
                'required' => false,
                'csrf_protection' => false, // Important pour Symfony 2.8
            ]);
    }

    public function getName()
    {
        return 'ecompetence_ecompetencebundle_divers';
    }
}