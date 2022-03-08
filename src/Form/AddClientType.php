<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'nom', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']

            ])
            ->add('prenom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'prenom', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']

            ])
            ->add('email', EmailType::class,[
                'required' =>true,
                'attr' =>['class' => 'form-control']
            ])
            ->add('tel', TelType::class,[
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' => false,
                 'attr' =>['class' => 'form-control']
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
