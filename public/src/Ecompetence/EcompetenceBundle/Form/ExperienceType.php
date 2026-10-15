<?php

namespace Ecompetence\EcompetenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Ecompetence\EcompetenceBundle\Entity\Structure;
use Ecompetence\EcompetenceBundle\Repository\StructureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ecompetence\EcompetenceBundle\Entity\Cv_directiongle;
use Ecompetence\EcompetenceBundle\Repository\Cv_directiongleRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
use Agent\AgentBundle\Form\PjRType;


class ExperienceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secteur',NULL,['label' => 'Secteur', 'empty_value' => '---- Choisir le Secteur ----', 'attr' => array('onchange' => 'searchList("#sec","affecter_structure_listetype","#str", "#viewstr")')])
            ->add('structure',EntityType::class,[
                 'class' => Structure::class,
                'query_builder' => function (StructureRepository $repo) {
                    return $repo->findAllOrderedByName();
                },'label' => 'Nom de l\'emploeur', 'empty_value' => '---- Choisir l\'employeur ----', 'attr' => array('onchange' => 'searchList("#str","affecter_directiongeneral_listetype","#cvdg", "#viewcvdg")')])
            ->add('cvdirectiongle',EntityType::class,['class' => 'EcompetenceBundle:Cv_directiongle',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d')
                                        ->orderBy('d.libdirectiongle', 'ASC');},'label' => 'Directions generale', 'empty_value' => '---- Choisir Direction générale ----', 'attr' => array('onchange' => 'searchList("#cvdg","affecter_directioncentrale_listetype","#cvdc", "#viewcvdc")')])
            ->add('cvdirection',EntityType::class,['class' => 'EcompetenceBundle:Cv_direction',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('d')
                                        ->orderBy('d.libdirection', 'ASC');},'label' => 'Direction','empty_value' => '---- Choisir Direction ----'])
            ->add('fonction',EntityType::class,[ 'class' => 'AgentBundle:Fonction',
                            'query_builder' => function(EntityRepository $repo) {
                                return $repo->createQueryBuilder('f')
                                        ->orderBy('f.libFonc', 'ASC');},
                'empty_value' => '---- Choisir le poste occupé -----'])
            ->add('libExp','text',array('label' => 'Poste occupé'))
            ->add('dateDebExp','datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy',
                  'attr' => array('required' => false,'class' => 'form-control datetimepicker')))
            ->add('dateFinExp','datetime', array('label' => 'Date de début','widget' => 'single_text', 'format' => 'dd-MM-yyyy',
                  'attr' => array('class' => 'form-control datetimepicker')))
            ->add('autrestructure',NULL,array( 'attr' => array('placeholder' => 'Si autre veuillez préciser')))
            ->add('pj',FileType::class/*,['constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ]]*/)
            ->add('mission','textarea',array('label'=>'Mission','required' => true,'attr' => array('placeholder' => ' Veuillez préciser les missionss'))) 
            ->add('agent')            
            ->add('enregistrer', 'submit', array('label' => '+  Enrégistrer experience'));
            
            
        // Ajouter un écouteur d'événements pour vérifier si la structure existe déjà
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            // Vérifier si une structure existe déjà dans la base de données
            $structureRepo = $form->getConfig()->getOption('structure_repository');
            //dump($structureRepo);die;
            $existingStructure = $structureRepo->findOneBy(['libStructure' => $data['structure']]);

            if ($existingStructure) {
                // Ajouter une erreur au formulaire si la structure existe déjà
                $form->get('structure')->addError(new FormError('Cette structure existe déjà.'));
            }
        });
    }
            
    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecompetence\EcompetenceBundle\Entity\Experience',
            'structure_repository' => null, // 🔥 ajout important
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecompetence_ecompetencebundle_experience';
    }
}
