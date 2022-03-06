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

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la résidence',
                'required' => true,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Ville',
            ])
            ->add('zip_code', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('country', TextType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Pays',
            ])
            ->add('inventory_file', FileType::class, [
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
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.role LIKE :role')
                        ->setParameter('role', '["ROLE_OWNER"]');
                },
            ])
            ->add('representative', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
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
