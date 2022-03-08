<?php

namespace App\Form;


use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'reference', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control','readonly'=> true]

            ])
            ->add('nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'nom', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']

            ])

            ->add('description',TextareaType::class,[
                'label' =>'description', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']

            ])
            ->add('prix', NumberType::class,[
                'required' =>true,
                'attr' =>['class' => 'form-control']
            ])
            ->add('stock', IntegerType::class,[
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' => true,
                'attr' =>['class' => 'form-control']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}