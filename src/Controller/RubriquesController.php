<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RubriquesController extends AbstractController
{
    /**
     * @Route("/rubriques", name="rubriques")
     */
    public function index(RubriqueRepository $repository){
        $rubriques = $repository->findAll();
        return $this->render('rubriques/index.html.twig', [
            'rubriques' => $rubriques
        ]);
    }

    /**
     * @Route("/rubriques/{id}", name="id")
     */
    public function articles(ArticleRepository $repository,$id){
        $articles=$repository->findBy(['rubrique'=>$id]);
        return $this->render('rubriques/articles.html.twig', [
            'articles' => $articles
        ]);
    }

}
