<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Zenstruck\Foundry\repository;

class CommentController extends AbstractController
{   
    private PostRepository $pRepo;

    public function __construct(PostRepository $pRepo)
    {
        $this->pRepo = $pRepo;        
    }

    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[IsGranted ('ROLE_USER')]
    #[ROUTE('/comment/create/{postId}', name:'comment.create')]
    public function create($postId, Request $request, CommentRepository $cRepo): Response
    {   
        $post = $this->pRepo->find($postId);    
        $commentBody=$request->toArray();
        // dd($commentBody);
        // comment est un objet que je dois creer pour ajouter a la bd, bd demande comme parametre un objet
        $comment= new Comment; 
        $comment->setCreatedAt(new DateTime());
        $comment->setContenue($commentBody['textareaComment']);
        $comment->setUser($this->getUser());
        $comment->setPost($post);
        // dd($comment);
        $cRepo->add($comment, true);

        $comments= $post->getComments();
        $allComments=[];
        foreach($comments as $comment)
        {
            $allComments[]=[
            'id'=> $comment->getId(),
            'createdAt'=> $comment->getCreatedAt(),
            'contenue'=> $comment->getContenue()
        ];}
        return $this->json($allComments);
    }
}
