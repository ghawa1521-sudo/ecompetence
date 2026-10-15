<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé de la décoration',
                'required' => true,
                'attr' => ['placeholder' => 'Ex: Médaille, Prix']
            ])
            ->add('annee', IntegerType::class, [
                'label' => 'Année d’obtention',
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'attr' => ['placeholder' => 'Ex: 2020']  // Ajout d'un placeholder
            ]);
            // ->add('enregistrer', 'submit', [
            //     'label' => '+ Enregistrer la décoration',
            //     'attr' => ['class' => 'btn btn-success']
            // ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Decoration',
        ]);
    }

    public function getName()
    {
        return 'ecompetence_ecompetencebundle_decoration';
    }
}