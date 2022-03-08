<?php

namespace App\Controller;

use App\Entity\Produit;

use App\Form\AddProduitType;
use App\Form\UpdatClientType;
use App\Form\UpdatProduitType;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{

    /*
     * méthode affichage
     */
    #[Route('/produit', name: 'produit')]
    public function produit(Request $request, ProduitRepository $repo): \Symfony\Component\HttpFoundation\Response
    {

        $produits = $repo->findBySearchProduct(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 5,
            $request->query->get('keyword'));

        $total =$repo->countBySearchProduct($request->query->get('keyword'));


        return $this->render('produit/index.html.twig',[
            'produits' => $produits,
            'total' => $total
        ]);
    }

    #[Route('produit/add', name: 'produit_add')]
    public function add(Request $request,
                        EntityManagerInterface $em,
                        ProduitRepository $repo){

        $produit = new Produit();
        //fonction des controllers qui permet de créer un formulaire
        $form =  $this->createForm(AddProduitType::class,$produit);

        //remplir / hydratation le message
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $ref = substr($produit->getNom(),0,4);

            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count,4,'0',STR_PAD_LEFT));

            $ref= strtoupper($ref);
            $produit->setReference($ref);


            $produit->setDeleted(false);
            // enregistrement local des changements
            $em->persist($produit);
            //suppression d'un client
            //$em->remove($client);
            //  sauvegared dans la db
            $em->flush();
            $this->addFlash('success', 'enregistrement OK' );
            return $this->redirectToRoute('produit');

        }

        return $this->render('produit/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /*
        * C'est une méthode pour supprimer un produit (modifier deleted)
        */
    #[Route('produit/delet/{id}', name: 'produit_delet')]
    public function delet(ProduitRepository $repo, EntityManagerInterface $em, int $id){

        //chercher l'objet client avec la méthode find
        $produit = $repo->find($id);

        //on vérifie si $client est null ou l'élément a dèja été supprimer
        if($produit === null || $produit->getDeleted()){
            throw new NotFoundHttpException();
        }

        //Modifier la propriété deleted
        $produit->setDeleted(1);

        //il éxécute la requete
        $em->flush();


        //Affichage de message de succes
        $this->addFlash('success' , 'Suppression OK');


        //Basculer la vue
        return $this->redirectToRoute('produit');

    }

    /*
    * c'est une méthode qui mofifier certains informations du produit
    */
    #[Route('produit/updat{id}' , name: 'produit_updat')]
    public function update(Request $request,ProduitRepository $repo, EntityManagerInterface $em, int $id){

        //chercher l'objet client avec la méthode find
        $produit = $repo->find($id);

        //fonction des controllers qui permet de créer un formulaire
        $form =  $this->createForm(UpdatProduitType::class,$produit);

        //remplir / hydratation le message
        $form->handleRequest($request);
        dump($produit);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($produit);

            $em->flush();

            //Affichage de message de succes
            $this->addFlash('success' , 'Modification OK');



            //Basculer la vue
            return $this->redirectToRoute('produit');
        }

        return $this->render('produit/updat.html.twig',[
            'form'=>$form->createView(), 'client' => $produit
        ]);
    }






}