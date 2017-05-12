<?php

namespace MainBundle\Form;

use MainBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eqId', null, [
                'label' => 'Enquetenaam',
                'data' => 'Enquete 1',
                'required' => true,
            ])
            ->add('title', null, [
                'label' => 'Vraagnaam'
            ]);
//            ->add('enqueteId')
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Question::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_question';
    }


}
