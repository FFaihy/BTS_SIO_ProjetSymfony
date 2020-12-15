<?php

namespace App\Controller;

use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GestionRubriqueController extends AbstractController
{
    /**
     * @Route("/gestion/rubrique", name="gestion_rubrique")
     */
    public function index(RubriqueRepository $repository)
    {
        $rubriques = $repository->findAll();
        return $this->render('gestion_rubrique/index.html.twig', [
            'rubriques' => $rubriques
        ]);
    }

    /**
     * @Route("/ajouter_rubrique/rubrique", name="ajouter_rubrique")
     */
    public function ajouter(Request $request)
    {

        $rubrique = new Rubrique();
        $ajouter = $this->createForm(RubriqueType::class, $rubrique);
        $ajouter->handleRequest($request);
        if ($ajouter->isSubmitted() && $ajouter->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rubrique);
            $em->flush();

            return $this->redirectToRoute('gestion_rubrique');
        }
        return $this->render('gestion_rubrique/ajouterRubrique.html.twig', [
            'ajouter' => $ajouter->createView()
        ]);
    }

    /**
     * @Route("/supprimer_rubrique/rubrique/{id}", name="supprimer_rubrique")
     */
    public function supprimer(RubriqueRepository $repository, $id)
    {
        $rubrique = $repository->findOneBy(['id' => $id]);
        try{
        $em = $this->getDoctrine()->getManager();
        $em->remove($rubrique);
        $em->flush();
        }
        catch (\Exception $e){
            $this->addFlash('danger', 'Impossible de supprimer une rubrique contenant des articles.');
        }
        return $this->redirectToRoute('gestion_rubrique'
        );
    }

    /**
     * @Route("/modifier_rubrique/rubrique/{id}", name="modifier_rubrique")
     */
    public function modifier(Request $request,RubriqueRepository $repository ,$id)
    {
        $rubrique = $repository->findOneBy(['id' => $id]);
        $modifier = $this->createForm(RubriqueType::class, $rubrique);
        $modifier->handleRequest($request);
        if ($modifier->isSubmitted() && $modifier->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('gestion_rubrique');
        }
        return $this->render('gestion_rubrique/modiferRubrique.html.twig', [
            'modifier' => $modifier->createView()
        ]);
    }
}