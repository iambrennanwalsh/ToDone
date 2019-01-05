<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdateUserType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
  	$builder
			->add('fname', TextType::class)
      ->add('lname', TextType::class)
			->add('username', TextType::class)
      ->add('email', EmailType::class)
      ->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'first_options'  => array('label' => 'Password'),
        'second_options' => array('label' => 'Repeat Password')))
			->add('country', CountryType::class, ["preferred_choices" => array('US')])
      ->add('gender', ChoiceType::class, array(
      	'choices'  => array(
         	'Male' => 'Male',
           'Female' => 'Female',
           'Other' => 'Other')))
			->add('submit', SubmitType::class);
}
  public function configureOptions(OptionsResolver $resolver) {
  	
		$resolver->setDefaults([
    	'data_class' => User::class]);}
}