<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{   
    private PostRepository $repo;
    public function __construct(PostRepository $repo)
    {
        $this->repo=$repo;
    }

    #[Route('/', name: 'post.index')]
    public function index(): Response
    {   
        $posts=$this->repo->findAll();
        
        return $this->render('post/index.html.twig', ['myposts'=>$posts]);
    }


    #[Route('/post/create', name:"post.create", methods:['GET', 'POST'])]
    public function create(Request $request):Response 
    {   
        // la class post, ou il y a le titre, la description, tout, je la crée et elle est vide
        $post = new Post(); 
        // je vais reemplir la classe post avec la class postType qui a tous les champs du formulaire
        $form = $this->createForm(PostType::class, $post);
        // creeateForm cree le formulaire que je vais affciher, et va se resembler a $post

        $form->handleRequest($request);
        // dd($request);

        return $this->renderForm('post/create.html.twig', ['form'=>$form]);

    }
}
