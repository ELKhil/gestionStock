<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client',EntityType::class,[
                "class"=> Client::class,
                'query_builder' => function (ClientRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.deleted = 0');},
                //affichage du label
                'label' =>'client', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
