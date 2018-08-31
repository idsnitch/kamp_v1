<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorporatePaymentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mobileNumber',null,[
                'label'=>'Mpesa Number'
            ])
            ->add('idemnifyFirstName',null,[
                'label'=>'First Name',
                'required'=>true
            ])
            ->add('idemnifyLastName',null,[
                'label'=>'Last Name',
                'required'=>true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\CorporateProfile'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundlepayment_form';
    }
}
