<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                'label' => 'Voornaam'
            ])
            ->add('lastname', null, [
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
                'label' => 'Geboortedatum',
                'years' => range(date('Y') - 107, date('Y'))
            ))
            ->add('address', null, [
                'label' => 'Adres',
            ])
            ->add('postal', null, [
                'label' => 'Postcode'
            ])
            ->add('city', null, [
                'label' => 'Woonplaats'
            ])
            ->add('phone', null, [
                'label' => 'Telefoonnummer'
            ])
            ->add('bankaccount', null, [
                'label' => 'Bankrekening'
            ])

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_user';
    }


}
