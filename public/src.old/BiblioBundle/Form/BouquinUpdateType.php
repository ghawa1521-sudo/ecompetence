<?php

namespace BiblioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agent\AgentBundle\Form\PjType;

class BouquinUpdateType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('direction')
                ->add('categorie')
                ->add('libelle')
                ->add('details')
                //->add('datecreation')
                /*
                ->add('datecreation', 'datetime', array('widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'date_format' => 'dd-MM-yyyy H:i', 'label' => 'Date de création',
                            'attr' => array('class' => 'form-control date-picker')))
                */
                //->add('createur')
                ->add('pj', new PjType(), [
                    'required' => true])
                //->add('droit')
                
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BiblioBundle\Entity\Bouquin'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bibliobundle_bouquin';
    }

}
