<?php

namespace Ecommerce\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ecommerce\EcommerceBundle\Form\MediaType;
use Ecommerce\EcommerceBundle\Form\TvaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProduitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('description')
                ->add('prix')
                ->add('disponible')
                ->add('image', MediaType::class)
                ->add('tva', EntityType::class, array('class'=>'EcommerceBundle:Tva','choice_label'=>'getNom'))
                ->add('categorie', EntityType::class, array('class'=>'EcommerceBundle:Categories','choice_label'=>'getNom'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecommerce\EcommerceBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecommerce_ecommercebundle_produits';
    }

}
