<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityRepository;
use Ecompetence\EcompetenceBundle\Entity\Structure;
use Ecompetence\EcompetenceBundle\Entity\Cv_directiongle;
use Ecompetence\EcompetenceBundle\Entity\Cv_direction;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secteur', null, [
                'label' => 'Secteur',
                'empty_value' => '---- Choisir le Secteur ----',
                'attr' => ['id'=>'sec']
            ])
            // Dropdown Nom employeur
            ->add('structure', 'entity', [
                'class' => Structure::class,
                'query_builder' => function ($repo) {
                    return $repo->createQueryBuilder('s')->orderBy('s.libStructure', 'ASC');
                },
                'label' => 'Nom de l\'employeur',
                'empty_value' => '---- Choisir l\'employeur ----',
                'required' => false,
            ])
            // Nom employeur libre
            ->add('autrestructure', TextType::class, [
                'label' => 'Nom de l\'employeur (autre)',
                'mapped' => true,
                'required' => false,
                'attr' => ['id' => 'autrestructure_hidden'],
            ])
            ->add('cvdirectiongle', 'entity', [
                'class' => Cv_directiongle::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')->orderBy('d.libdirectiongle', 'ASC');
                },
                'label' => 'Direction générale',
                'empty_value' => '---- Choisir Direction générale ----',
                'required' => false,
            ])
            ->add('cvdirectiongle_txt', TextType::class, [
                'label' => 'Direction générale (autre)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('cvdirection', 'entity', [
                'class' => Cv_direction::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')->orderBy('d.libdirection', 'ASC');
                },
                'label' => 'Direction',
                'empty_value' => '---- Choisir Direction ----',
                'required' => false,
            ])
            ->add('cvdirection_txt', TextType::class, [
                'label' => 'Direction (autre)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('fonction', 'entity', [
                'class' => 'AgentBundle:Fonction',
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('f')->orderBy('f.libFonc', 'ASC');
                },
                'label' => 'Poste occupé',
                'empty_value' => '---- Choisir le poste ----',
                'required' => false,
            ])
            ->add('libExp', TextType::class, [
                'label' => 'Poste occupé (autre)',
                'mapped' => true,
                'required' => false,
                'attr' => ['id' => 'libExp_hidden'],
            ])
            ->add('dateDebExp','datetime', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'form-control datetimepicker']
            ])
            ->add('dateFinExp','datetime', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'form-control datetimepicker']
            ])
            ->add('pj', FileType::class, ['required' => false])
            ->add('mission','textarea', [
                'label' => 'Mission',
                'required' => true,
                'attr' => ['placeholder' => 'Veuillez préciser les missions']
            ])
            ->add('agent', null)
            ->add('enregistrer', SubmitType::class, [
                'label' => '+ Enregistrer expérience'
            ]);

        // PRE_SUBMIT pour gérer les champs libres
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $secteur = isset($data['secteur']) ? $data['secteur'] : null;

            if ($secteur == 2) { // secteur privé
                if (!empty($data['autrestructure'])) $data['structure'] = null;
                if (!empty($data['libExp'])) $data['fonction'] = null;
                if (!empty($data['cvdirectiongle_txt'])) $data['cvdirectiongle'] = null;
                if (!empty($data['cvdirection_txt'])) $data['cvdirection'] = null;
            }

            // injection champs libres (mais mappés côté contrôleur)
            $event->setData($data);
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Experience',
            'structure_repository' => null,
        ]);
    }

    public function getName()
    {
        return 'ecompetence_ecompetencebundle_experience';
    }
}