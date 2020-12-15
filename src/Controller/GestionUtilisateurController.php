<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use App\Form\ModifMDPType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GestionUtilisateurController extends AbstractController
{
    /**
     * @Route("/gestion/utilisateur", name="gestion_utilisateur")
     */
    public function index(UtilisateurRepository $repository)
    {
        $utilisateurs = $repository->findAll();
        return $this->render('gestion_utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }

    /**
     * @Route("/ajouter/utilisateur", name="ajouter")
     */
    public function ajouter(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $utilisateur = new Utilisateur();
        $ajouter = $this->createForm(InscriptionType::class, $utilisateur);
        $ajouter->handleRequest($request);
        if($ajouter->isSubmitted() && $ajouter->isValid()){
            $utilisateur->setMdp(
                $passwordEncoder->encodePassword($utilisateur,$ajouter->get('mdp')->getData())
            );
            $em = $this->getDoctrine()->getManager();
            $utilisateur->setRole(["ROLE_REDACTEUR"]);
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('gestion_utilisateur');
        }
        return $this->render('gestion_utilisateur/ajouter.html.twig', [
            'ajouter'=>$ajouter->createView()
        ]);
    }

    /**
     * @Route("/supprimer/utilisateur/{id}", name="supprimer")
     */
    public function supprimer(UtilisateurRepository $repository,$id)
    {
            $utilisateur = $repository->findOneBy(['id'=>$id]);
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();

        return $this->redirectToRoute('gestion_utilisateur'
            );
    }

    /**
     * @Route("/revoquer/utilisateur/{id}", name="revoquer")
     */
    public function revoquer(UtilisateurRepository $repository,$id)
    {
        $utilisateur = $repository->findOneBy(['id'=>$id]);
        $utilisateur->setRole(["ROLE_UTILISATEUR"]);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('gestion_utilisateur'
        );
    }

    /**
     * @Route("/modifier_utilisateur/utilisateur/{id}", name="modifier_utilisateur")
     */
    public function modifier(Request $request,UtilisateurRepository $repository ,$id)
    {
        $utilisateur = $repository->findOneBy(['id' => $id]);
        $modifier = $this->createForm(ModifMDPType::class, $utilisateur);
        $modifier->handleRequest($request);
        if ($modifier->isSubmitted() && $modifier->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('gestion_utilisateur');
        }
        return $this->render('gestion_utilisateur/modifierMdp.html.twig', [
            'modifier' => $modifier->createView()
        ]);
    }
}
