<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class IndividualRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Fabio'
                ],
                ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Shiba'
                ],
                ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail',
                'attr' => [
                    'placeholder' => 'iloveshiba@gmail.com'
                ],
                ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'help' => 'Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffres, un caractère spécial et doit faire au moins 8 caractères',
                'attr' => [
                    'placeholder' => 'Azerty#123'
                ],
                'mapped' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('address', TextType::class,[
                'label' => 'Adresse postale',
                'attr' => [
                    'placeholder' => '1 boulevard du Shiba'
                ],
            ])
            ->add('zip_code', NumberType::class,[
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => '75009'
                ],
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Paris'
                ],
            ])
            ->add('country', TextType::class,[
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'France'
                ],
            ])
            ->add('phone_number', NumberType::class,[
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => '0102030405'
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Valider les conditions de vente et d\'utilisation',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
