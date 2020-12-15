<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GestionArticleController extends AbstractController
{
    /**
     * @Route("/gestion/article", name="gestion_article")
     */
    public function index(RubriqueRepository $repository)
    {
        $rubriques = $repository->findAll();
        return $this->render('gestion_article/index.html.twig', [
            'rubriques' => $rubriques

        ]);
    }
    /**
     * @Route("/ajouter_article/article", name="ajouter_article")
     */
    public function ajouter(Request $request)
    {

        $article = new Article();
        $ajouter = $this->createForm(ArticleType::class, $article);
        $ajouter->handleRequest($request);
        if($ajouter->isSubmitted() && $ajouter->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('gestion_article');
        }
        return $this->render('gestion_article/ajouterArticle.html.twig', [
            'ajouter'=>$ajouter->createView()
             ]);
    }
    /**
     * @Route("/supprimer_article/article/{id}", name="supprimer_article")
     */
    public function supprimer(ArticleRepository $repository,$id)
    {
        $article = $repository->findOneBy(['id'=>$id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('gestion_article'
        );
    }

    /**
     * @Route("/modifier_article/article/{id}", name="modifier_article")
     */
    public function modifier(Request $request,ArticleRepository $repository ,$id)
    {
        $article = $repository->findOneBy(['id' => $id]);
        $modifier = $this->createForm(ArticleType::class, $article);
        $modifier->handleRequest($request);
        if ($modifier->isSubmitted() && $modifier->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('gestion_article');
        }
        return $this->render('gestion_article/modifierArticle.html.twig', [
            'modifier' => $modifier->createView()
        ]);
    }
}
