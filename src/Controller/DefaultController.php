<?php


namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository; // Ajoutez le repository des articles
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {
        // Récupérer toutes les catégories
        $categories = $categoryRepository->findAll();

        // Récupérer tous les articles (exemple)
        $articles = $articleRepository->findAll();

        // Passer les catégories et les articles au template Twig
        return $this->render('default/home.html.twig', [
            'categories' => $categories,
            'articles' => $articles, 
        ]);
    }
}
