<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private CategoryRepository $repo;
    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    // #[ROUTE('/category', name:'category.index')]
    // public function index(): Response
    // {
    //     $categories=$this->repo->findAll();
    //     return $this->render('category/index.html.twig', ['categories'=>$categories]);
    // }


    // ajouter category
    #[ROUTE('/category', name: 'category.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $category = new Category();
        $form=$this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if(
            $form->isSubmitted() 
        // $form->isValid()
        ){ 
            //this is the way to keep in the bd $category
            $this->repo->add($category, true);
            return $this->redirect('/category');
        }
        $categories =$this->repo->findAll();
        return $this->renderForm('category/index.html.twig', ['form'=>$form, 'categories'=>$categories]);
    }

    #[ROUTE('/category/{id}', name: 'category.show', methods: ['GET'])]
    public function show($id): Response
    {
        $category = $this->repo->find($id);
        $posts = $category->getPost();
        return $this->render('/category/show.html.twig', ['posts' => $posts, 'category' => $category]);
    }

    // delete
    #[ROUTE('/category/delete/{id}', name: 'category.delete', methods: ['POST'])]
    public function delete($id)
    {
        $category = $this->repo->find($id);
        $posts = $category->getPost();

        // methode isEmpty pour verifier si la category ne contient pas de post
        // si la category ne contient pas de post on l'a suprime
        if ($posts->isEmpty()) {
            $this->repo->remove($category, true);
        }
        return $this->redirect('/');
    }

    // modifier
    #[ROUTE('/category/edit/{id}', name:'category.edit', methods:['GET', 'POST'])]
    public function edit($id, Request $request): Response
    {
        $category= $this->repo->find($id);
        $nom=trim($request->get('nom'));
        $submit=trim($request->get('submit'));
        // je recupere le nom de la category avec l'input name et le get
        if(isset($submit)&& !empty($nom)){
        $category->setName($nom);
        // je modifie la category avec le set
        $this->repo->update();
        // je la pousse dans la base de données 
        return $this->redirect('/category');
        }
        // si le form est envoyé et si le nom et le champ n'est pas vide
        return $this->render('/category/edit.html.twig', ['category'=>$category]);


    }


}
