<?php

namespace App\Controller;


use App\Entity\Client;
use App\Form\AddClientType;
use App\Form\UpdatClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client_clients')]
    public function client(Request $request, ClientRepository $repo): \Symfony\Component\HttpFoundation\Response
    {

        $clients = $repo->findBySearch(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 5,
            $request->query->get('keyword'));

        $total =$repo->countBySearch($request->query->get('keyword'));


        return $this->render('client/clients.html.twig',[
                'clients' => $clients,
                'total' => $total
            ]);
    }

    #[Route('client/add', name: 'client_add')]
    public function add(Request $request,
                        EntityManagerInterface $em,
                        ClientRepository $repo){

        $client = new Client();
        //fonction des controllers qui permet de créer un formulaire
        $form =  $this->createForm(AddClientType::class,$client);

        //remplir / hydratation le message
        $form->handleRequest($request);
        dump($client);

        if($form->isSubmitted() && $form->isValid()){

            $ref = substr($client->getNom(),0,2);
            $ref.= substr($client->getPrenom(),0,2);
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count,4,'0',STR_PAD_LEFT));

            $ref= strtoupper($ref);
            $client->setReference($ref);


            $client->setDeleted(false);
            // enregistrement local des changements
            $em->persist($client);
            //suppression d'un client
            //$em->remove($client);
            //  sauvegared dans la db
            $em->flush();
            $this->addFlash('success', 'enregistrement OK' );
            return $this->redirectToRoute('client_clients');

        }

        return $this->render('client/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }



        /*
         * C'est une méthode pour supprimer un client (modifier deleted)
         */
        #[Route('client/delet/{id}', name: 'client_delet')]
        public function delet(ClientRepository $repo, EntityManagerInterface $em, int $id){

            //chercher l'objet client avec la méthode find
            $client = $repo->find($id);

            //on vérifie si $client est null ou l'élément a dèja été supprimer
            if($client === null || $client->getDeleted()){
                throw new NotFoundHttpException();
            }

            //Modifier la propriété deleted
            $client->setDeleted(1);

            //il éxécute la requete
            $em->flush();


            //Affichage de message de succes
            $this->addFlash('success' , 'Suppression OK');


            //Basculer la vue
            return $this->redirectToRoute('client_clients');

        }

        /*
         * c'est une méthode qui mofifier certains informations du client
         */
        #[Route('client/updat{id}' , name: 'client_updat')]
        public function update(Request $request,ClientRepository $repo, EntityManagerInterface $em, int $id){

            //chercher l'objet client avec la méthode find
            $client = $repo->find($id);

            //dans le cas ou $Clien et null ou Delted est true on lance une exception 404,
            if($client == null || $client->getDeleted()){
                throw new NotFoundHttpException();
            }
            //fonction des controllers qui permet de créer un formulaire
            $form =  $this->createForm(UpdatClientType::class,$client);

            //remplir / hydratation le message
            $form->handleRequest($request);
            dump($client);

            if($form->isSubmitted() && $form->isValid()){

                $em->persist($client);

                $em->flush();

                //Affichage de message de succes
                $this->addFlash('success' , 'Modification OK');



                //Basculer la vue
                return $this->redirectToRoute('client_clients');
            }

               return $this->render('client/updat.html.twig',[
                   'form'=>$form->createView(), 'client' => $client
               ]);
        }




}