<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\LigneCommande;
use App\Form\RechercheCommandeType;
use App\Form\UpdateCommandeType;
use App\Form\UpdatProduitType;
use App\Model\Commande\SearchCommandForm;
use App\Repository\EtatsRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use App\Form\AddCommandeType;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    #[IsGranted('ROLE_admin')]
    public function commande(Request $request, CommandeRepository $repo): \Symfony\Component\HttpFoundation\Response
    {

        //créer un objet SearchCommanForm
        $search = new SearchCommandForm();


        $form= $this->createForm(RechercheCommandeType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commandes = $repo->search($search->reference, $search->client, $search->startAt, $search->endAt, $search->etats);

        } else {
            $commandes = $repo->findAll();
        }

        return $this->render('commande/index.html.twig',[
            'commandes' => $commandes,
            'form' => $form->createView()
        ]);
    }


    #[Route('commande/add', name: 'commande_add')]
    public function add(Request $request,
                        EntityManagerInterface $em,
                        CommandeRepository $repo,
                        EtatsRepository $repoEtat)
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
            //$commande->setClient($form->get("client")->getData());

            $etat = $repoEtat->find(1);
            $commande->setEtat($etat);

            $ref = date("ymd");
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count,4,'0',STR_PAD_LEFT));

            $ref= strtoupper($ref);
            $commande->setReference($ref);

            dump($commande);
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success', 'enregistrement OK' );

            return $this->redirectToRoute('commande_updat',['id' => $commande->getId()]);
        }


        return $this->render('commande/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('commande/updat{id}' , name: 'commande_updat', requirements: ['id' => '\d+'])]
    public function update(Request $request,CommandeRepository $repo, EntityManagerInterface $em, int $id){

        //chercher l'objet client avec la méthode find
        $commande = $repo->findWithClient($id);

        //fonction des controllers qui permet de créer un formulaire
        $form =  $this->createForm(UpdateCommandeType::class,$commande);

        //remplir / hydratation le message
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($commande);

            $em->flush();

            //Affichage de message de succes
            $this->addFlash('success' , 'Modification OK');

            //Basculer la vue
            return $this->redirectToRoute('commande');
        }

        return $this->render('commande/update.html.twig',[
            'form'=>$form->createView(),
            'commandes' => $commande
        ]);
    }

    #[Route('/commande/addLine/{id}' , name: 'commande_add_line')]
    public function ajouterLigne($id,Request $request,EntityManagerInterface $em,
                                 CommandeRepository $repo, ProduitRepository $produitRepository
                                ,LigneCommandeRepository $ligneCommandeRepository){
        // est ce qu'il existe une commande lié a l'id
        $commande = $repo->findWithLinesAndProducts($id);

        if($commande === null){
            throw new NotFoundHttpException(); // errur 404 url est mauvais
        }
      /*  if($commande->getEtat()->getNom() != "InProgress"){
            throw new BadRequestHttpException();
        }*/

        $produitId = $request->request->get('produitId');
        $quantity = $request->request->get('quantity');

        //cherche les lignes d'un tableau qui respecte une certain condition
/*
        $results = array_filter($commande->getLignes()->toArray(), function ($item) use($produitId){
            return $item->getProduit()->getId() == $produitId;
        });*/

        // est ce que le produit déja été utilisé
        $ligne =$ligneCommandeRepository->findOneBy([
            'produit_id'=>$produitId,
            'commande'=> $id]);

        if($ligne == null){
            $ligne = new LigneCommande();
            $p= $produitRepository->findOneBy(['id'=>$produitId, 'deleted' =>false]);

            if($p === null){
                // code erreur 400
                throw new BadRequestHttpException();
            }
            $ligne->setProduitId($p);
            $ligne->setQuantite($quantity);
            $ligne->setCommande($commande);
            $commande->addLigne($ligne);
            $em->persist($ligne);
            $em->flush();
        }else{
            $ligne->setQuantite($quantity);
            $em->flush();
        }

        return new JsonResponse(array_map(
            function($item) {return $item->serialize();},
            $commande->getLignes()->toArray()));

    }

    #[Route('commandes/lines/{id}', name : 'commandes_lines')]
    public function getLines($id , CommandeRepository $repository){
        $commande =$repository->findWithLinesAndProducts($id);

        if($commande === null){
            throw new NotFoundHttpException();
        }
        return new JsonResponse(array_map(
            function($item) {return $item->serialize();},
            $commande->getLignes()->toArray()
        ));
    }
}