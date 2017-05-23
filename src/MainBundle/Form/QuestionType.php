<?php

namespace MainBundle\Form;

use MainBundle\Entity\Choice;
use MainBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
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
            ])
        ->add('choices',CollectionType::class,[
            'label' => 'Keuzes',
            'entry_type' => ChoiceType::class,
            'allow_add' => true,
            'prototype' => true,
            'by_reference' => false,
            'allow_delete' =>true,
            'delete_empty' => true,
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
