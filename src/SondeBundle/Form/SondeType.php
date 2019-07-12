<?php

namespace SondeBundle\Form;

use SondeBundle\Entity\Sonde;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SondeType
 *
 * @package SondeBundle\Form
 */
class SondeType extends AbstractType
{
    /**
     * Build the form elements
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rpm',
                TextType::class,
                [
                    'label' => 'RPM',
                    'attr' => [
                        'size' => '5',
                    ]
                ]
            )
            ->add('save',
                SubmitType::class,
                [
                    'label' => 'Save',
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ]
                ]
            );
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sonde::class,
        ]);
    }
}
