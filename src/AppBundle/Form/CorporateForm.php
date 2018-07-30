<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorporateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyType', ChoiceType::class, array(
                'choices' => array(
                    'Sole Proprietorship' => 'Sole Proprietorship',
                    'Partnership' => 'Partnership',
                    'Limited Company' => 'Limited Company'
                ),
                'placeholder'=>'Select'
            ))
            ->add('companyName')
            ->add('firstDirectorNames')
            ->add('firstDirectorId')
            ->add('email',RepeatedType::class,[
                'type' => EmailType::class
            ])
            ->add('termsOfService',CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\OnBoard'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_corporate_form';
    }
}
