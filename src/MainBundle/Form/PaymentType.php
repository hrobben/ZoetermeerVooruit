<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class PaymentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('uId', null, [
                    'label' => 'Gebruiker'
                ])
                ->add('date', DateType::class,[
                    'format' => 'ddMMyyyy',
                    'label' => 'Datum van betaling',
                ])
                ->add('amount', MoneyType::class, [
                'divisor' => 1,
                'label'=>'Bedrag',
                ])
                ->add('completePayment', CheckboxType::class, [
                'label' => 'Is dit het volledige bedrag?',
                'required' => false,
    ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Payment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_payment';
    }


}
