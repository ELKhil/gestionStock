<?php

namespace App\Form;


use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Etats;
use App\Model\Commande\SearchCommandForm;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'Réference', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>false,  //le  champs est requis
                'attr' =>['class' => 'form-control']

            ])

            ->add('client',EntityType::class,[
                "class"=> Client::class,
                'query_builder' => function (ClientRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.deleted = 0');},
                //affichage du label
                'label' =>'client', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>false,  //le  champs est requis
                'attr' =>['class' => 'form-control']
            ])

            ->add('startAt', DateType::class,[
                'label' =>'Entre le',
                'widget' => "single_text",
                'required' =>false,
                'attr' =>['class' => 'form-control']
            ])

            ->add('endAt', DateType::class,[
                'label' =>'et le',
                'widget' => "single_text",
                'required' =>false,
                'attr' =>['class' => 'form-control']
            ])

            ->add('etats',EntityType::class,[
                "class"=> Etats::class,
                //affichage du label
                'label' =>'Etats', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>false,  //le  champs est requis
                'attr' =>['class' => 'form-control',
                ]
            ])

        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchCommandForm::class,
        ]);
    }
}