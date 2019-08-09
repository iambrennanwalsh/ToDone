<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', NumberType::class)
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password')
            ))
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'Male' => 'Male',
                    'Female' => 'Female',
                    'Other' => 'Other'
                )
            ))
            ->add('country', CountryType::class, array(
                'data' => 'US',
                'preferred_choices' => array('US', 'CA', 'GB', 'AU')
            ))
            ->add('terms', CheckboxType::class, [
                'label' => 'I agree to the terms and conditions.',
                'mapped' => false,
                'constraints' => new IsTrue()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
