<?php

namespace App\Controller;

use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('menu/index.html.twig'
        );
    }

    /**
     * @Route("/redacteur", name="redacteur")
     */
    public function accueilRedacteur()
    {
        return $this->render('redacteur/index.html.twig'
        );
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function accueilAdmin()
    {
        return $this->render('admin/index.html.twig'
        );
    }

}
