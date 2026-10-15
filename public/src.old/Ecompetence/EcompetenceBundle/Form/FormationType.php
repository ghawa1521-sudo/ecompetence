<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Form\PjRType;
use Ecompetence\EcompetenceBundle\Entity\Diplome;
use Ecompetence\EcompetenceBundle\Repository\DiplomeRepository;
use Ecompetence\EcompetenceBundle\Entity\Niveau;
use Ecompetence\EcompetenceBundle\Repository\NiveauRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ecompetence\EcompetenceBundle\Entity\Specialite;
use Ecompetence\EcompetenceBundle\Repository\SpecialiteRepository;
use Ecompetence\EcompetenceBundle\Entity\Optiondiplome;
use Ecompetence\EcompetenceBundle\Repository\OptiondiplomeRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\File as FileConstraint;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class FormationType extends AbstractType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('dateObtentiondiplo','datetime', array('label' => 'Date de début','widget' => 'single_text', 'format' => 'dd-MM-yyyy',
                  'attr' => array('class' => 'form-control datetimepicker')))
            ->add('libFormation',NULL,array('required'=> false, 'attr' => array('placeholder' => 'Titre de la formation')))
            ->add('typeformation',NULL,['required'=> false,'empty_value' => '---- Choisir le type de formation ----'])
            ->add('niveauFormation', EntityType::class, [
                'class' => Niveau::class,
                'query_builder' => function (NiveauRepository $repo) {
                    return $repo->findAllOrderedByName();
                },
                'required' => false,
                'placeholder' => '---- Choisir le diplôme ----',
                'attr' => [
                    'onchange' => 'searchList("#diplome","listespecialite","#specialite", "#viewspecialite")'
                ],
                 ])
            //->add('niveauFormation',NULL,['required'=> true,'empty_value' => '---- Choisir le niveau d\'étude ----','attr' => array('onchange' => 'searchList("#niveau","listediplome","#diplome", "#viewoptdipl")')])
            ->add('diplome', EntityType::class, [
                'class' => Diplome::class,
                'query_builder' => function (DiplomeRepository $repo) {
                    return $repo->findAllOrderedByName();
                },
                'required' => false,
                'placeholder' => '---- Choisir le diplôme ----',
                'attr' => [
                    'onchange' => 'searchList("#diplome","listespecialite","#specialite", "#viewspecialite")'
                ],
            ])
            //->add('diplome',NULL,['required'=> false,'empty_value' => '---- Choisir le diplôme ----','attr' => array('onchange' => 'searchList("#diplome","listespecialite","#specialite", "#viewspecialite")')])
            ->add('specialite', EntityType::class, [
                'class' => 'EcompetenceBundle:Specialite',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')
                    ->orderBy('d.libspecialite', 'ASC');
                },
                'required' => false,
                'placeholder' => '---- Choisir le diplôme ----',
                'attr' => [
                    'onchange' => 'searchList("#diplome","listespecialite","#specialite", "#viewspecialite")'
                ],
            ])
            //->add('specialite',NULL,['required'=> false,'empty_value' => '---- Renseignez la spécialité----','attr' => array('onchange' => 'searchList("#specialite","listeoption","#option", "#viewoption")')])
            ->add('option', EntityType::class, [
                'class' => 'EcompetenceBundle:Optiondiplome',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')
                    ->orderBy('d.libOption', 'ASC');
                },
                'required' => false,
                'placeholder' => '---- Choisir le diplôme ----',
                'attr' => [
                    'onchange' => 'searchList("#diplome","listespecialite","#specialite", "#viewspecialite")'
                ],
            ])
            // ->add('option',NULL,['required'=> false,'label' => 'Option','empty_value' => '---- Choisir l\'option ----'])
            ->add('etablissement',EntityType::class,['class' => 'EcompetenceBundle:Etablissement',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('d')
                    ->orderBy('d.nomEtablissement', 'ASC');
                },'required'=> false,'empty_value' => '---- Choisir le nom d\'institut ----'])
            ->add('autreetablissement',NULL,array( 'required'=> false,'label' => 'Autre'))
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false,
            ])
            ->add('pjFile', FileType::class, [
                  'mapped' => false, // ❗ très important
                  'required' => false,
                  'constraints' => [
                   new FileConstraint([
                  'maxSize' => '1024k',
                  'mimeTypes' => [
                  'application/pdf',
                  'application/x-pdf',
            ],
            'mimeTypesMessage' => 'Veuillez uploader un document PDF valide',
        ])
    ],
])
            /*->add('pj', FileType::class,['constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ]]
            )*/
           
            ->add('enregistrer', 'submit', array('label' => '+  Enrégistrer formation'));
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Formation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecompetence_ecompetencebundle_formation';
    }
}
