<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
class DomaineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
   


public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
            // Champ texte pour le libellé
            ->add('libDomaine', 'text')

            // Sélecteur pour le parent (relation ManyToOne vers Domaine)
            ->add('parent', 'entity', [
                'class' => 'EcompetenceBundle:Domaine',
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')
                                ->orderBy('d.libDomaine', 'ASC');
                },
                'choice_label' => 'libDomaine',
                'placeholder'  => 'Sélectionnez un parent',
                'required'     => false,
            ])

            // Champ optionnel level
            ->add('level', 'integer', [
                'required' => false,
            ]);
}
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Domaine'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecompetence_ecompetencebundle_domaine';
    }
}
