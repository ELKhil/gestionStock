<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Etats;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'reference', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' => false,  //le  champs est requis
                'attr' => ['class' => 'form-control', 'readonly' => true]
            ])
            ->add('creationDate', DateType::class, [
                'label' => 'Date',
                'widget' => "single_text",
                'required' => false,
                'attr' => ['class' => 'form-control', 'readonly' => true]
            ])

            ->add('client',EntityType::class,[
                "class"=> Client::class,
                //affichage du label
                'label' =>'client', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>false,  //le  champs est requis
                'attr' =>['class' => 'form-control','readonly' => true]
            ])
            ->add('etat',EntityType::class,[
                "class"=> Etats::class,
                //affichage du label
                'label' =>'Etats', //affichage du label
                'label_attr' => ['class' => 'forme-label','readonly' => true ], //ajouter des attribut au label
                'required' =>false,  //le  champs est requis
                'attr' =>['class' => 'form-control',
                ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);

    }

}