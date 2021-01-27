<?php

namespace AppBundle\Form;

use AppBundle\Entity\Template;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use AppBundle\Entity\Sinatzaileak;
use AppBundle\Entity\Eskaera;

class EskaeraType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add(
                'type',
                EntityType::class,
                [
                    'label'         => 'Mota',
                    'required'      => true,
                    'expanded'      => true,
                    'class'         => 'AppBundle\Entity\Type',
                    'attr'          => array('class' => 'type_label'),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                  ->where('u.erakutsi_eskaera=true')
                                  ->orderBy('u.created', 'DESC');
                    },
                    'choice_label'  => function ($template) {
                        /* @var  $template Template */
                        return trim($template->getName());
                    },
                    'choice_attr'   => function ($val, $key, $index) {
                        // adds a class like attending_yes, attending_no, etc
                        return ['class' => 'attending_'.strtolower($key)];
                    },
                ]
            )
            ->add(
                'hasi',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'html5'  => false,
                ]
            )
            ->add(
                'amaitu',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'html5'  => false,
                ]
            )
            ->add('egunak')
            ->add('orduak')
            ->add(
                'total',
                null,
                array(
                    'attr' => array(
                        'readonly' => false,
                    ),
                )
            )
            ->add('oharra')
            ->add(
                'noiz',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'html5'  => false,
                    'attr'   => ['class' => 'js-datepicker', 'data-provide' => 'datepicker'],
                ]
            )
            ->add('justifikanteFile', VichFileType::class)
            ->add('user')
            ->add('calendar')
            ->add(
                'sinatzaileak',
                EntityType::class,
                [
                    'label'         => 'Sinatzaile zerrenda',
                    'placeholder'   => 'Aukeratu bat...',
                    'required'      => false,
                    'class'         => Sinatzaileak::class,
                    'query_builder' => static function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                  ->orderBy('u.name', 'ASC');
                    },
                    'choice_label'  => static function ($template) {
                        /* @var  $template Template */
                        return trim($template->getName());
                    },
                ]
            )
            ->add(
                'nondik',
                ChoiceType::class,
                [
                    'choices'     => array(
                        'Orduak' => 'Orduak',
                        'Egunak' => 'Egunak',
                    ),
                    'placeholder' => '::Aukeratu::',
                ]
            )
            ->add(
                'lizentziamota'
            )
            ->add('kostua', MoneyType::class, [
                'label' => 'Kostua',
                'divisor' => 100,
                'required' => false,

            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => Eskaera::class,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_eskaera';
    }
}
