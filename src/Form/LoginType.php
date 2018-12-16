<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
  	$builder
			->add('username', TextType::class, array(
    				'attr' => array('class' => 'input',
													 	'placeholder' => 'Username or Email'), 
						'required' => true))
      ->add('password', PasswordType::class, array(
    				'attr' => array('class' => 'input',
														'name' => 'password',
													 	'placeholder' => 'Password'), 
						'required' => true))
      ->add('login', SubmitType::class, array(
    				'attr' => array('class' => 'button is-primary is-pulled-right')))
			;
	}
}