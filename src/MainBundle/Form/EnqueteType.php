<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\CheckboxTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnqueteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Enquetenaam'])
            ->add('description', null, ['label' => 'Beschrijving'])
            ->add('startDate', DateTimeType::class,[
                'date_widget' => 'single_text',
                'label' => 'Startdatum',
            ])
            ->add('endDate', DateTimeType::class,[
                'date_widget' => 'single_text',
                'label' => 'Einddatum',
            ])
            ->add('published', CheckboxType::class, [
                'label' => 'Publiceren',
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Enquete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_enquete';
    }


}
