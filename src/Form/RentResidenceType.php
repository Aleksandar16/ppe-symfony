<?php

namespace App\Form;

use App\Entity\Rent;
use App\Entity\Residence;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RentResidenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                        'mimeTypesMessage' => 'Format PDF uniquement',
                    ])
                ],
            ])
            ->add('arrival_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('departure_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('tenant', EntityType::class, [
                'class' => User::class,
                'label' => 'Locataire',
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'selectpicker'
                ),
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.role LIKE :role')
                        ->setParameter('role', '["ROLE_TENANT"]');
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
            'data_class' => Rent::class,
        ]);
    }
}
