<?php

namespace VOCS\PlatformBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VOCS\PlatformBundle\Entity\Classes;
use VOCS\PlatformBundle\Entity\Lists;
use VOCS\PlatformBundle\Entity\User;
use VOCS\PlatformBundle\Entity\WordTrad;

class DemandsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userSend', EntityType::class, array(
                "class" => User::class,
            ))
            ->add('userReceive', EntityType::class, array(
                "class" => User::class,
            ))
            ->add('classe', EntityType::class, array(
                "required" => false,
                "class" => Classes::class,
            ))
            ->add('list', EntityType::class, array(
                "required" => false,
                "class" => Lists::class,
            )
            )->add('wordTrad', WordTradType::class, array(
                "required" => false,

            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VOCS\PlatformBundle\Entity\Demands',
            'csrf_protection' => false

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vocs_platformbundle_demands';
    }


}
