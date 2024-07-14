<?php

namespace App\Controller;

use App\Entity\Article;
use App\Handler\ArticleHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $articleHandler;

    public function __construct(ArticleHandler $articleHandler)
    {
        $this->articleHandler = $articleHandler;
    }

    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/article/new', name: 'article_new')]
    public function new(Request $request): Response
    {
        $form = $this->articleHandler->handleNew($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}', name: 'article_show')]
    public function show(Article $article): Response
    {
        $article = $this->articleHandler->handleShow($article);

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/{id}/edit', name: 'article_edit')]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->articleHandler->handleEdit($request, $article);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}/delete', name: 'article_delete')]
    public function delete(Request $request, Article $article): Response
    {
        $this->articleHandler->handleDelete($request, $article);

        return $this->redirectToRoute('app_article');
    }
}
