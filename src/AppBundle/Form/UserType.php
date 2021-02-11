<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('displayname', null, [
                'label' => 'Izen Abizenak',
                'required' => true
            ])
            ->add('nan', null, [
                'label' => 'NAN',
                'required' => true
            ])
            ->add('lanpostua', null, [
                'label' => 'Lanpostua',
                'required' => true
            ])
            ->add('saila', null, [
                'label' => 'Saila',
                'required' => false
            ])
            ->add('azpisaila', null, [
                'label' => 'Azpi saila',
                'required' => false
            ])
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return '';
    }


}
