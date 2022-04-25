<?php

namespace App\Form;

use App\Entity\Informations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class InformationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse')
            ->add('numeroAppartement', IntegerType::class, [
                'label' => 'N° Appartement (facultatif)',
                'required' => false,
            ])
            ->add('batiment', TextType::class, [
                'label' => 'Bâtiment (facultatif)',
                'required' => false,
            ])
            ->add('etage', IntegerType::class, [
                'label' => 'Etage (facultatif)',
                'required' => false,
            ])
            ->add('codePostal', IntegerType::class, [
                'constraints' => [new Length(['min' => 5, 'max' => 5])],
            ])
            ->add('ville')
            ->add('telephone', IntegerType::class, [
                'constraints' => [new Length(['min' => 10, 'max' => 10, 'minMessage' => 'erreur', 'maxMessage' => 'erreur'])],
                'label' => 'Téléphone',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Informations::class,
        ]);
    }
}
