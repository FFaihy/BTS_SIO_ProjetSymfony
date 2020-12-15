<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $utilisateur = new Utilisateur();
        $inscription = $this->createForm(InscriptionType::class, $utilisateur);
        $inscription->handleRequest($request);
        if($inscription->isSubmitted() && $inscription->isValid()){
            $utilisateur->setMdp(
                $passwordEncoder->encodePassword($utilisateur,$inscription->get('mdp')->getData())
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('accueil');
        }
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'inscription'=>$inscription->createView()
        ]);
    }
}
