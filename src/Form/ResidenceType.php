<?php

namespace App\Form;

use App\Entity\Residence;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResidenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la résidence',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer le nom de la résidence',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => true,
                'attr' => ['class' => 'tinymce'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Ville',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer le nom de la ville',
                    ]),
                ],
            ])
            ->add('zip_code', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['class' => 'tinymce'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer le code postal',
                    ]),
                ],
            ])
            ->add('country', TextType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Pays',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer le nom du pays',
                    ]),
                ],
            ])
            ->add('inventoryFile', FileType::class, [
                'label' => 'Gabarit inventaire',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Format PDF uniquement',
                    ])
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Format jpeg, png, jpg uniquement',
                    ])
                ],
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'label' => 'Bailleur',
                'required' => true,
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'selectpicker'
                ),
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.role LIKE :role')
                        ->setParameter('role', '["ROLE_OWNER"]');
                },
            ])
            ->add('representative', EntityType::class, [
                'class' => User::class,
                'label' => 'Mandataire',
                'required' => true,
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'selectpicker'
                ),
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.role LIKE :role')
                        ->setParameter('role', '["ROLE_REPRESENTATIVE"]');
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Residence::class,
        ]);
    }
}
