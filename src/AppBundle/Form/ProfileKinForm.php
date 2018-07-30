<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileKinForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('kinFirstName',null,[
            'required'=>true
        ])
        ->add('kinMiddleName',null,[
            'required'=>true
        ])
        ->add('kinLastName',null,[
            'required'=>true
        ])
        ->add('kinRelationship',null,[
            'required'=>true
        ])
        ->add('kinIdNumber',null,[
            'required'=>true
        ])
        ->add('kinDateOfBirth',DateType::class,[
            'widget' => 'single_text',
            'attr' => ['class' => 'js-date'],
            'html5' => false,
        ])
        ->add('kinGender',ChoiceType::class,array(
            'choices'=>array(
                'Male'=>'Male',
                'Female'=>'Female',
            ),
            'choices_as_values' => true,
            'multiple'=>false,
            'expanded'=>true,
            'required' => true,
        ))
        ->add('kinPhysicalAddress')
        ->add('kinCity')
        ->add('kinCounty', ChoiceType::class, array(
            'choices' => array(
                'Nairobi' => 'Nairobi',
                'Mombasa' => 'Mombasa',
                'Kisumu' => 'Kisumu',
                'Muranga' => 'Muranga',
                'Nakuru' => 'Nakuru',
                'Nyeri' => 'Nyeri',
                'Machakos' => 'Machakos',
                'Bungoma' => 'Bungoma',
                'Busia' => 'Busia',
                'Elgeyo Marakwet' => 'Elgeyo Marakwet',
                'Embu' => 'Embu',
                'Garrisa' => 'Garrisa',
                'Homa Bay' => 'Homa Bay',
                'Isiolo' => 'Isiolo',
                'Kajiado' => 'Kajiado',
                'Kakamega' => 'Kakamega',
                'Kericho' => 'Kericho',
                'Kiambu' => 'Kiambu',
                'Kilifi' => 'Kilifi',
                'Kirinyaga' => 'Kirinyaga',
                'Kisii' => 'Kisii',
                'Kitui' => 'Kitui',
                'Kwale' => 'Kwale',
                'Laikipia' => 'Laikipia',
                'Lamu' => 'Lamu',
                'Makueni' => 'Makueni',
                'Mandera' => 'Mandera',
                'Marsabit' => 'Marsabit',
                'Meru' => 'Meru',
                'Migori' => 'Migori',
                'Nandi' => 'Nandi',
                'Narok' => 'Narok',
                'Nyamira' => 'Nyamira',
                'Nyandarua' => 'Nyandarua',
                'Samburu' => 'Samburu',
                'Siaya' => 'Siaya',
                'Taita Taveta' => 'Taita Taveta',
                'Tana River' => 'Tana River',
                'Tharaka Nithi' => 'Tharaka Nithi',
                'Trans Nzoia' => 'Trans Nzoia',
                'Turkana' => 'Turkana',
                'Uasin Gishu' => 'Uasin Gishu',
                'Vihiga' => 'Vihiga',
                'Wajir' => 'Wajir',
                'West Pokot' => 'West Pokot',
            ),
            'placeholder'=>'Select'
        ))
        ->add('kinPostalAddress')
        ->add('kinPostalCode')
        ->add('kinTelephoneNumber')
        ->add('kinMobileNumber')
        ->add('kinEmailAddress')
        ->add('isKinMinor')
        ->add('kinGuardian')
        ->add('otherKinFirstName')
        ->add('otherKinMiddleName')
        ->add('otherKinLastName')
        ->add('otherKinRelationship')
        ->add('otherKinIdNumber')
        ->add('otherKinDateOfBirth',DateType::class,[
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'],
            'html5' => false,
            'required'=>false
        ])
        ->add('otherKinGender',ChoiceType::class,array(
            'choices'=>array(
                'Male'=>'Male',
                'Female'=>'Female',
            ),
            'choices_as_values' => true,
            'multiple'=>false,
            'expanded'=>false,
            'required' => false,
        ))
        ->add('otherKinPhysicalAddress')
        ->add('otherKinCity')
        ->add('otherKinCounty', ChoiceType::class, array(
            'choices' => array(
                'Nairobi' => 'Nairobi',
                'Mombasa' => 'Mombasa',
                'Kisumu' => 'Kisumu',
                'Muranga' => 'Muranga',
                'Nakuru' => 'Nakuru',
                'Nyeri' => 'Nyeri',
                'Machakos' => 'Machakos',
                'Bungoma' => 'Bungoma',
                'Busia' => 'Busia',
                'Elgeyo Marakwet' => 'Elgeyo Marakwet',
                'Embu' => 'Embu',
                'Garrisa' => 'Garrisa',
                'Homa Bay' => 'Homa Bay',
                'Isiolo' => 'Isiolo',
                'Kajiado' => 'Kajiado',
                'Kakamega' => 'Kakamega',
                'Kericho' => 'Kericho',
                'Kiambu' => 'Kiambu',
                'Kilifi' => 'Kilifi',
                'Kirinyaga' => 'Kirinyaga',
                'Kisii' => 'Kisii',
                'Kitui' => 'Kitui',
                'Kwale' => 'Kwale',
                'Laikipia' => 'Laikipia',
                'Lamu' => 'Lamu',
                'Makueni' => 'Makueni',
                'Mandera' => 'Mandera',
                'Marsabit' => 'Marsabit',
                'Meru' => 'Meru',
                'Migori' => 'Migori',
                'Nandi' => 'Nandi',
                'Narok' => 'Narok',
                'Nyamira' => 'Nyamira',
                'Nyandarua' => 'Nyandarua',
                'Samburu' => 'Samburu',
                'Siaya' => 'Siaya',
                'Taita Taveta' => 'Taita Taveta',
                'Tana River' => 'Tana River',
                'Tharaka Nithi' => 'Tharaka Nithi',
                'Trans Nzoia' => 'Trans Nzoia',
                'Turkana' => 'Turkana',
                'Uasin Gishu' => 'Uasin Gishu',
                'Vihiga' => 'Vihiga',
                'Wajir' => 'Wajir',
                'West Pokot' => 'West Pokot',
            ),
            'placeholder'=>'Select',
            'required'=>false
        ))
        ->add('otherKinPostalAddress')
        ->add('otherKinPostalCode')
        ->add('otherKinTelephoneNumber')
        ->add('otherKinMobileNumber',null,[
            'required'=>false
        ])
        ->add('otherKinEmailAddress')
        ->add('isOtherKinMinor')
        ->add('otherKinGuardian');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Profile'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_profile_kin_form';
    }
}
