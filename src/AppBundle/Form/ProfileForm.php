<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('applicantName')
            ->add('idNumber')
            ->add('itaxPin')
            ->add('dateOfBirth',DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
            ])
            ->add('gender',ChoiceType::class,array(
                'choices'=>array(
                    'Male'=>'Male',
                    'Female'=>'Female',
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'required' => true,
            ))
            ->add('physicalAddress',[
                'required'=>true
            ])
            ->add('city',[
                'required'=>true
            ])
            ->add('county', ChoiceType::class, array(
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
            ->add('postalAddress')
            ->add('postalCode')
            ->add('telephoneNumber')
            ->add('mobileNumber',null,[
                'attr'=>['placeholder'=>'254720123456']
                ])
            ->add('emailAddress')
            ->add('emailAddress2')
            ->add('website')
            ->add('isCollectingSocietiesMember',ChoiceType::class,array(
                'choices'=>array(
                    'Yes'=>'Yes',
                    'No'=>'No',
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'required' => true,
            ))
            ->add('collectingSocieties')
            ->add('termsOfService',CheckboxType::class)
            ->add('kinFirstName')
            ->add('kinMiddleName')
            ->add('kinLastName')
            ->add('kinRelationship')
            ->add('kinIdNumber')
            ->add('kinDateOfBirth',DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
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
            ])
            ->add('otherKinGender',ChoiceType::class,array(
                'choices'=>array(
                    'Male'=>'Male',
                    'Female'=>'Female',
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'required' => true,
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
                'placeholder'=>'Select'
            ))
            ->add('otherKinPostalAddress')
            ->add('otherKinPostalCode')
            ->add('otherKinTelephoneNumber')
            ->add('otherKinMobileNumber')
            ->add('otherKinEmailAddress')
            ->add('isOtherKinMinor')
            ->add('otherKinGuardian')
            ->add('paymentMpesaNumbe')
            ->add('accountName')
            ->add('accountNumber')
            ->add('bank',ChoiceType::class, array(
                'choices' => array(
                    'Africa Banking Corporation' => 'Africa Banking Corporation',
                    'Bank of Africa' => 'Bank of Africa',
                    'Bank of Baroda' => 'Bank of Baroda',
                    'Bank of India' => 'Bank of India',
                    'Barclays Bank' => 'Barclays Bank',
                    'CFC Stanbic Bank' => 'CFC Stanbic Bank',
                    'Chase Bank' => 'Chase Bank',
                    'Citibank NA' => 'Citibank NA',
                    'Commercial Bank of Africa' => 'Commercial Bank of Africa',
                    'Consolidated Bank' => 'Consolidated Bank',
                    'Co-operative Bank' => 'Co-operative Bank',
                    'Credit Bank' => 'Credit Bank',
                    'Development Bank' => 'Development Bank',
                    'Diamond Trust Bank' => 'Diamond Trust Bank',
                    'Dubai Bank' => 'Dubai Bank',
                    'Ecobank' => 'Ecobank',
                    'Equitorial Commercial Bank' => 'Equitorial Commercial Bank',
                    'Equity Bank' => 'Equity Bank',
                    'Family Bank' => 'Family Bank',
                    'Fidelity Commercial Bank' => 'Fidelity Commercial Bank',
                    'Fina Bank' => 'Fina Bank',
                    'First Community Bank' => 'First Community Bank',
                    'Giro Commercial Bank' => 'Giro Commercial Bank',
                    'Guardian Bank' => 'Guardian Bank',
                    'Gulf African Bank' => 'Gulf African Bank',
                    'Habib Bank A.G Zurich' => 'Habib Bank A.G Zurich',
                    'Habib Bank' => 'Habib Bank',
                    'Imperial Bank' => 'Imperial Bank',
                    'I&M Bank' => 'I&M Bank',
                    'Jamii Bora Bank' => 'Jamii Bora Bank',
                    'Kenya Commercial Bank' => 'Kenya Commercial Bank',
                    'K-Rep Bank' => 'K-Rep Bank',
                    'Middle East Bank' => 'Middle East Bank',
                    'National Bank of Kenya' => 'National Bank of Kenya',
                    'NIC Bank' => 'NIC Bank',
                    'Oriental Commercial Bank' => 'Oriental Commercial Bank',
                    'Paramount Universal Bank' => 'Paramount Universal Bank',
                    'Prime Bank' => 'Prime Bank',
                    'Standard Chartered Bank' => 'Standard Chartered Bank',
                    'Trans-National Bank' => 'Trans-National Bank',
                    'UBA Kenya Bank' => 'UBA Kenya Bank',
                    'Victoria Commercial Bank' => 'Victoria Commercial Bank',
                    'Housing Finance' => 'Housing Finance',
                ),
                'placeholder'=>'Select'
            ))
            ->add('bankBranch')
            ->add('bankCode')
            ->add('swiftCode');


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Profile'
        ]);
    }

    public function getName()
    {
        return 'app_bundle_profile_form';
    }
}
