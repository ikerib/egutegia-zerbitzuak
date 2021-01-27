<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GutxienekoakdetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gutxienekoak')
            ->add('user',EntityType::class, [
                'required'=>true,
                'label' => 'Langilea',
                'placeholder'=>'Aukeratu bat...',
                'class' => 'AppBundle\Entity\User',
                'attr' => array(
                    'class'=>'nireselect2'
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.displayname', 'ASC');
                },
                'choice_label' => function ($u) {
                    /* @var  $u \AppBundle\Entity\User */
                    return $u->getUsername() . ' ('.$u->getDisplayname().')';
                },
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Gutxienekoakdet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_gutxienekoakdet';
    }


}
