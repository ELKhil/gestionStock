<?php

namespace App\Form;

use App\Entity\Message;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\DependencyInjection\Compiler\CheckArgumentsValidityPass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MessageType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //les champs contenu dans mon formulaire
        $builder
            ->add('firstName',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'First Name', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']

            ])
            ->add('lastName',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' =>'Last Name',
                'label_attr' => ['class' => 'forme-label'],
                'required' =>true,
                'attr' =>['class' => 'form-control']

            ])

            ->add('birthDate', BirthdayType::class,[
                'widget' => "single_text",
                'required' =>true,
                'attr' =>['class' => 'form-control']
            ])

            ->add('genre', ChoiceType::class,[
                'choices'  => [
                    //ce que l'on va afficher => ce que l'on va sauvegarder
                    'Mr' => "Monsieur",
                    'Mme' => "Madame",
                    'Mlle' => "Mlle",
                ],
                'expanded' =>false, // des radios ou checkboxs par default false
                'multiple' => false, //select multiple ou checkboxs par default false
                'required' =>true,
                'attr' =>['class' => 'form-select']
            ])


            ->add('email', EmailType::class,[
                'required' =>true,
                'attr' =>['class' => 'form-control']
             ])
            ->add('subject',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'required' =>true,
                'attr' =>['class' => 'form-control']
            ])
            ->add('content',TextareaType::class,[
                'required' =>false,
                'attr' =>['class' => 'form-control',
                'rows' => "10"]
            ])
            ->add('fichier', FileType::class,[
                'required' =>false,
                'label' =>'Downoald File',
                'attr' =>['class' => 'form-control'],
                'constraints' => [
                    new File(['maxSize'=>'2m', 'mimeTypes' =>['application/pdf']])
                ]

            ])
            ->add('accepter',CheckboxType::class,[
                'required' =>true,
                //'attr' =>['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            //le nom de la classe liée au formulaire
            ['data_class'=>Message::class]
            //retirer la protectio csrf
            /* 'csrf_protection'=> false*/
        );
    }

}