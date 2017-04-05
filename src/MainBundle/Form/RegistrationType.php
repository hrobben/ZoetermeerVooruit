<?php

namespace MainBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', [
                'label' => 'Voornaam'
            ])
            ->add('lastname', [
                'label' => 'Achternaam'
            ])
            ->add('gender', ChoiceType::class, array(
                'choices'   => array(
                'Man'       => "Man",
                'Vrouw'     => "Vrouw"
                ),
                'label'     => 'Geslacht',
                ))
            ->add('birthdate', DateType::class, array(
                'format' => 'dd MM yyyy',
            ))
            ->add('address', [
                'label' => 'Adres',
            ])
            ->add('postal', [
                'label' => 'Postcode'
            ])
            ->add('city', [
                'label' => 'Woonplaats'
            ])
            ->add('phone', [
                'label' => 'Telefoonnummer'
            ])
            ->add('bankaccount', [
                'label' => 'Bacnkrekening'
            ])

        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'mainbundle_user';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}