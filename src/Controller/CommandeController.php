<?php

namespace App\Controller;

use Symfony\Component\Validator\Constraints\Date;
use App\Form\AddCommandeType;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function commande(Request $request, CommandeRepository $repo): \Symfony\Component\HttpFoundation\Response
    {
        $commandes = $repo->findAll();
        return $this->render('commande/index.html.twig',[
            'commandes' => $commandes
        ]);
    }
    #[Route('commande/add', name: 'commande_add')]
    public function add(Request $request,
                        EntityManagerInterface $em,
                        CommandeRepository $repo)
    {
        $commande = new Commande();
        //fonction des controllers qui permet de créer un formulaire
        $form = $this->createForm(AddCommandeType::class,$commande);
        //remplir / hydratation le message
        $form->handleRequest($request);



        if($form->isSubmitted() )//&& $form->isValid()){
        {
            $commande->setCreationDate( new \DateTime("now"));
            $commande->setUpdateDate(new \DateTime("now"));
            $commande->setEtat(2);
            $commande->setClient($request->query->get("add_commande[client]"));
            $commande->setClient($form->get("client")->getData());


            $ref = date("ymd");
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count,4,'0',STR_PAD_LEFT));

            $ref= strtoupper($ref);
            $commande->setReference($ref);

            dump($commande);
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success', 'enregistrement OK' );

            return $this->redirectToRoute('commande');
        }


        return $this->render('commande/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}