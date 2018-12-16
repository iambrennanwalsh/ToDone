<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForgotType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
  	$builder
			->add('email', EmailType::class, array(
    				'attr' => array('class' => 'input',
													 	'placeholder' => 'The email you signed up with.'), 
						'required' => true))
      ->add('submit', SubmitType::class, array(
    				'attr' => array('class' => 'button is-primary is-pulled-right')))
			;
	}
}