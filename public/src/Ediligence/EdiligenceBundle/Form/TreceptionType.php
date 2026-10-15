<?php

namespace Ediligence\EdiligenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TreceptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datereception', DateType::class, array('widget' => 'single_text',
                    'label' => 'Date Reception:',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'input-datepicker')))
           // ->add('etatreception')
           // ->add('matriculereception')
          //  ->add('codecourrier')
          //  ->add('idImput')
            ->add('chrono')
            //->add('courrier', HiddenType::class, array('data'=>''))
            ->add('idImput', HiddenType::class, array('data'=>''))
            //->add('typecourrier', HiddenType::class, array('data'=>''))
         //   ->add('courrier')
          //  ->add('typecourrier')$builder->add('token', HiddenType::class, array('data' => 'abcdef',));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ediligence\EdiligenceBundle\Entity\Treception'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ediligence_ediligencebundle_treception';
    }
}
