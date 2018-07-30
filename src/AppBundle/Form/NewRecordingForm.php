<?php

namespace AppBundle\Form;

use AppBundle\Entity\DocumentFile;
use AppBundle\Entity\RecordingFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewRecordingForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('albumTitle')
            ->add('dateOfProduction', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
                'label' => 'Date of Production'
            ])
            ->add('recordingStudio')
            ->add('countryOfRecording',CountryType::class)
            ->add('countryOfProduction',CountryType::class)
            ->add('format', ChoiceType::class, [
                'choices' => array(
                    'MP3' => 'MP3',
                    'MP4' => 'MP4'
                ),
                'required' => true,
                'label' => 'Format',
                'placeholder'=>'Select Format'
            ])
            ->add('mainArtist')
            ->add('documentFile',DocumentFileForm::class,[
                'label'=>'Signed Audio/Visual Declaration Form'
            ])
            ->add('letterOfAdministration',DocumentFileForm::class,[
                'label'=>'Letter of Administration',
                'required'=>false
            ])
            ->add('deathCertificate',DocumentFileForm::class,[
                'label'=>'Death Certificate',
                'required'=>false
            ])
            ->add('artistContract',DocumentFileForm::class,[
                'label'=>'Artist Contract',
                'required'=>false
            ])
            ->add('recordingFile',RecordingFileForm::class)
            ->add('sampleType', ChoiceType::class, [
                'choices' => array(
                    'Own' => 'Own',
                    'On Behalf of Artist' => 'On Behalf of Artist',
                    'On Behalf of Child' => 'On Behalf of Child',

                ),
                'required' => true,
                'label' => 'Ownership',
                'placeholder'=>'Select'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Music'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_new_recording_form';
    }
}
