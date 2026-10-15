<?php

namespace Ediligence\EdiligenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Agent\AgentBundle\Form\PjType;
use Doctrine\ORM\EntityRepository;
class Tcourrier_iType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet', TextareaType::class, array('attr' => array('class' => 'textarea-editor', 'rows' => '5')))
            ->add('numenregistrement', null, array('label'=>'Numero D\'enregistrement:'))  
            ->add('piecejointe', new PjType(), ['required' => false]);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ediligence\EdiligenceBundle\Entity\Tcourrier_i'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ediligence_ediligencebundle_tcourrier_i';
    }
}
