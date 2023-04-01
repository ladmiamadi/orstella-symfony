<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de renseigner ce champs',
                        ]),
                        new Length([
                            'min' => 2,
                            'minMessage' => 'Le titre doit contenir au moins {{ limit }} charactères',
                            'max' => 256,
                        ]),

                    ],
                    'label'=> 'Titre'
                ])
            ->add('price', MoneyType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de renseigner ce champs',
                        ]),
                        new Positive([
                            'message' => 'Le prix doit être supérieur à zéro'
                        ]),
                    ],
                    'label'=> 'Prix',
                    'currency' =>'',
                    'invalid_message' => 'Cette valeur n\'est pas valide'
                ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'constraints' => [
                    new Positive([
                        'message' => 'Quantité invalide'
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Télécharger une image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un type valide',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
