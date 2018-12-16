<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class ChangeType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
  	$builder
			->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'first_options'  => array('label' => 'Password',
																  'attr' => array('class' => 'input', 'placeholder' => 'New Password')),
        'second_options' => array('label' => 'Repeat Password',
																	'attr' => array('class' => 'input', 'placeholder' => 'Confirm Password'))))
      ->add('submit', SubmitType::class, array(
    				'attr' => array('class' => 'button is-primary is-pulled-right')))
			;
	}
}