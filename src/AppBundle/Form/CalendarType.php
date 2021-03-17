<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $username = $options['username'];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Izena',
                'required' => true,
            ])
            ->add('year', TextType::class, ['label_attr' => ['class' => '']])
            ->add('user')
            ->add('username', TextType::class, [
                'mapped' => false,
                'data' => $username,
            ])
            ->add('template', EntityType::class, [
                'required' => true,
                'class' => 'AppBundle\Entity\Template',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.created', 'DESC');
                },
                'choice_label' => function ($template) {
                    /* @var  $template \AppBundle\Entity\Template */
                    return $template->getName().'('.$template->getHoursYear().')';
                }, ]
            )
            ->add('hoursYear', NumberType::class, [
                'label_attr' => ['class' => 'col-sm-4'],
                'label' => 'Urteko lan orduak:',
                'required' => true,
            ])
            ->add('hoursFree', NumberType::class, [
                'label' => 'Opor orduak hartuta',
                'required' => true,
            ])
            ->add('hoursFreeLastYear', NumberType::class, [
                'label' => 'Aurreko urtekoak',
                'required' => true,
            ])
            ->add('hoursSelf', NumberType::class, [
                'label' => 'Norberarentzako orduak',
                'required' => true,
            ])
            ->add('hoursSelfHalf', NumberType::class, [
                'label' => 'Norberarentzako orduak zatituta max',
                'required' => true,
            ])
            ->add('hoursSindikal', NumberType::class, [
                'label' => 'Ordu Sindikalak',
                'required' => true,
            ])
            ->add('hoursCompensed', NumberType::class, [
                'label' => 'Urterako ordu konpentsatuak',
                'required' => true,
            ])
            ->add('hoursDay', NumberType::class, [
                'label' => 'Jornada',
                'required' => true,
            ])
            ->add('percentYear', NumberType::class, [
                'label' => 'Portzentaia',
                'required' => true,
            ])
            ->add('hirurtekoa', NumberType::class, [
                'label' => 'Hirurtekoak',
                'required' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Calendar',
            'username' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_calendar';
    }
}
