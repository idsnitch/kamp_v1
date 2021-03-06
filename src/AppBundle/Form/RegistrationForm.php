<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('middleName')
            ->add('lastName')
            ->add('userType', ChoiceType::class, array(
                'choices' => array(
                    'Individual' => 'Individual',
                    'Deceased Producer'=>'Deceased Producer',
                    'Sole Proprietorship' => 'Sole Proprietorship',
                    'Partnership' => 'Partnership',
                    'Limited Company' => 'Limited Company'
                ),
                'placeholder'=>'Select',
                'label'=>'Account Type'
            ))
            ->add('producerRelationship', ChoiceType::class, array(
                'choices' => array(
                    'Wife' => 'Wife',
                    'Husband'=>'Husband',
                    'Mother' => 'Mother',
                    'Brother' => 'Brother',
                    'Sister' => 'Sister',
                    'Son'=>'Son',
                    'Daughter'=>'Daughter'
                ),
                'placeholder'=>'Select',
                'label'=>false,
                'required'=>false
            ))
            ->add('email',RepeatedType::class,[
                'type' => EmailType::class
            ])
            ->add('plainPassword',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'attr'=>['class'=>'form-control'],
            ])
            ->add('phoneNumber',null,[
                'attr'=>[
                    'placeholder'=>'254720123456'
                    ]
            ])
            ->add('isTermsAccepted');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_registration_form';
    }
}
