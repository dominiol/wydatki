<?php

namespace App\Form;

use App\Entity\Transaction;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Adding a new transaction
 * @package App\Form
 */
class TransactionAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('value', NumberType::class)
            ->add('isPlanned', ChoiceType::class, [
                'choices' => [
                    'Standardowa' => false,
                    'Zaplanowana' => true
                ]
            ])
            ->add('save', SubmitType::class, array('label' => 'Zapisz'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transaction::class,
        ));
    }
}