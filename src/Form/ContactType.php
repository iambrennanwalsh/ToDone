<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
						->setMethod('POST')
            ->add('fname', TextType::Class)
						->add('email', EmailType::Class)
						->add('subject', TextType::Class)
						->add('message', TextareaType::Class)
						->add('submit', SubmitType::Class)
        ;
    }
}
