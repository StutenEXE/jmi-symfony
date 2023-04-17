<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Componenet\Form\Extension\Core\Type\{TextType,SubmitType,ResetType};
use Symfony\Component\Validator\Constraints\Regex;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('nom', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label_attr' => ['class' => 'form_label'],
                'attr' => ['class' => 'form-input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Nom trop court',
                        'max' => 50,
                        'maxMessage' => 'Nom trop long'
                    ])
                ]
            ])
            ->add('num', \Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label_attr' => ['class' => 'form_label'],
                'attr' => ['class' => 'form-input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer votre prénom'
                    ]),
                    new Regex([
                        'pattern' => '/[0-9]{2,50}/',
                        'message' => 'Le num doit être avoir entre 2 et 50 chiffres'
                    ])
                ]
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
