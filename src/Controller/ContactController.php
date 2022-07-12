<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private ContactRepository $repo;
    public function __construct(ContactRepository $repo)
    {
        $this->repo = $repo;
    }


    #[Route('/contact', name: 'contact.index')]
    public function index(): Response
    {
        return $this->render('contact/create.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }


    #[ROUTE('/contact/create', name: 'contact.create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response
    {
        
        $submit = $request->get('submit');
        $errors=[];

        if (!isset($submit)) {
            return $this->render('contact/create.html.twig');
        }
       

        $name = trim($request->get('name'));
        if (empty($name)) {
            $errors['name']= 'A name is required';
            // return $this->render('contact/create.html.twig', [
            //     'contacts' => $contacts
            // ]);
        }

        $email = trim($request->get('email'));
        if (empty($email)) {
            $errors['email']= 'An email is required';

        }

        $phone = trim($request->get('phone'));
        if (empty($phone)) {
           $errors['phone']='A phone number is required';
        }

        $message = trim($request->get('message'));
        if (empty($message)) {
            $errors['message']='A message is required';
        }

        if(empty($errors)){
            $contact=new Contact();

            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setPhone($phone);
            $contact->setMessage($message);

            $this->repo->add($contact, true);
            // dd($contact);
            return $this->redirect('/');
        }else{

            return $this->renderForm('/contact/create.html.twig');
        }
        


     
    }
}
