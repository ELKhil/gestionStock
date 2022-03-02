<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home')]
    public function home(Request $request): Response
    {
        // $request->query contient tous les parametres "GET"
        // $request->request contient tous les paramettres "POST"
        // $request->sessions contient les variables de session

        //permettre de récupérer la valeur de $_Get['name']
        $name = $request->query->get('name');
        //dump($name);
        return $this->render('default/home.html.twig');
    }
    #[Route(
        path: '/contact/{id}',
        name: 'default_contact',
        requirements:[
            'id' => '\d+' //'[0-9]?'
        ],defaults:  [
            'id' => 1
        ]
    )]
    public function contact(int $id){
        if($id === 1){
            $model = 'khun';
        }else if ($id === 2){
            $model = 'Flavian';
        }else{
            //declencher une erreur 404
            throw new NotFoundHttpException();
        }
        return $this->render('default/contact.html.twig',[
            'model' => $model
        ]);

    }
    #[Route(path:'/contactez-nous', name: 'default_contact_us',)]

    public function contacteUs(Request $request, MailerInterface $mailer , SluggerInterface $slugger){
        //récupération des données en post (ne pas utiliser de cette maniere (passer par
        //$name =$request->request->get('name');
        //$email =$request->request->get('email');
        //$objet =$request->request->get('subject');
        //$content =$request->request->get('content');
        $message = new Message();
        dump($message);
        //fonction des controllers qui permet de créer un formulaire
        $form =  $this->createForm(MessageType::class,$message);

        //remplir / hydratation le message
        $form->handleRequest($request);
        dump($message);

        if($form->isSubmitted() && $form->isValid()){
            //envoyer dans la db ou envoyer un emal ...
            $email =new Email();
            $email->to('m.s.elkhil@gmail.com');
            $email->from('noreply.bformation@gmail.com');
            //$email->subject($message->getSubject());
            //$email->text($message->getContent());


            $email->html($this->renderView('mail/contact-us.html.twig', [
                'model' => $message
            ]));

           // $email->html(sprintf("<h2>%s %s</h2> <p>%s</p> <p>%s</p>",$message->getFirstName(),
               // $message->getLastName(),$message->getContent(),$message->getEmail()));
            // $email->html(sprintf("<h1>%s</h1>",$message->getLastName()));*/
            //$email->html(sprintf("<p>%s</p>", $message->getEmail()));

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('fichier')->getData();

            if ($brochureFile) {
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                    dump("hello");
                } catch (FileException $e) {
                    $this->addFlash('error', "le fichier n'a pas pu etre télécharger");
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $message->setFichier($newFilename);

            }


                try {
                    $mailer->send($email);
                    //notification ook
                    $this->addFlash('success','Votre message a été bien envoyé');
                } catch (TransportExceptionInterface $e) {
                    //notification not ok
                    $this->addFlash('error','une erreur est survenue, vueillez nous en excuser');
                }





           return $this->redirectToRoute('default_home');
        }


        return $this->render('default/contactez-nous.html.twig',[
            'form'=>$form->createView()
        ]);
    }







}
