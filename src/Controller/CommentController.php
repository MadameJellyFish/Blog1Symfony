<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{   private PostRepository $pRepo;
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

    #[ROUTE('/comment/create/{postId}', name:'comment.create')]
    public function create($postId): Response
    {   $post = $this->pRepo->find($postId);
        $comments= $post->getComments();
        $allComments=[];
        foreach($comments as $comment)
        {
            $allComments[]=[
            'id'=> $comment->getId(),
            'createrAt'=> $comment->getCreatedAt(),
            'contenue'=> $comment->getContenue(),
        ];}
        return $this->json($allComments);
    }

}
