<?php

namespace App\Controller;


use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client_clients')]
    public function client(Request $request, ClientRepository $repo): \Symfony\Component\HttpFoundation\Response
    {

        $clients = $repo->findBySearch(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 2,
            $request->query->get('keyword'));

        return $this->render('client/clients.html.twig',[
                'clients' => $clients,
            ]);
}

}