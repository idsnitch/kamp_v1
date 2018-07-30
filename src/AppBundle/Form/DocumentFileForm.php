<?php

namespace AppBundle\Form;

use AppBundle\Entity\DocumentFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DocumentFileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('documentFile',VichFileType::class,[
               'label'=>false,
               'allow_delete'=>false
           ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => DocumentFile::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_document_file_form';
    }
}
