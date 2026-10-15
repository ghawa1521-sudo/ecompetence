<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConnaissanceInformatiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé de la connaissance',
                'required' => true,
                'attr' => ['placeholder' => 'Ex: Word, Excel, Photoshop…']
            ])
            ->add('niveau', ChoiceType::class, [
                'label' => 'Niveau',
                'choices' => [
                    'Débutant' => 'Débutant',
                    'Intermédiaire' => 'Intermédiaire',
                    'Avancé' => 'Avancé',
                    'Expert' => 'Expert',
                ],
                'required' => true,
                'placeholder' => '---- Choisir le niveau ----',
            ]);
            // ->add('enregistrer', 'submit', [
            //     'label' => '+ Enregistrer la connaisance',
            //     'attr' => ['class' => 'btn btn-success']
            // ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\ConnaissanceInformatique',
        ]);
    }

    public function getName()
    {
        return 'ecompetence_ecompetencebundle_connaissanceinformatique';
    }
}