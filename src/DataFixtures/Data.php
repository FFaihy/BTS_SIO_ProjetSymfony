<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Rubrique;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Data extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $u1 = new Utilisateur();
        $u1->setNom("FAIHY")
            ->setPrenom("Florian")
            ->setEmail("fl.faihy@gmail.com")
            ->setMdp($this->encoder->encodePassword($u1, '123'))
            ->setRole(["ROLE_ADMINISTRATEUR"])
        ;
        $manager->persist($u1);

        $r1 = new Rubrique();
        $r1->setNomRubrique("Musculation");
        $manager->persist($r1);

        $r2 = new Rubrique();
        $r2->setNomRubrique("Fitness");
        $manager->persist($r2);

        $r3 = new Rubrique();
        $r3->setNomRubrique("Autres");
        $manager->persist($r3);

        $a1 =new Article();
        $a1->setNomArticle("Les Bibis")
            ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque aliquam consequat felis eu sagittis. Phasellus nisi sem, varius in pharetra ut, lobortis vel arcu. Cras volutpat laoreet lectus id auctor.")
            ->setRubrique($r1)
        ;
        $manager->persist($a1);

        $a2 =new Article();
        $a2->setNomArticle("Les Pecs")
            ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut diam lorem, ullamcorper eget nunc eu, ultricies malesuada dui. Sed bibendum interdum maximus. Donec sed pharetra nisi. Vivamus congue, risus ac congue convallis, ligula turpis mollis nulla, ac vehicula purus magna ac arcu. Sed sit amet.")
            ->setRubrique($r1)
        ;
        $manager->persist($a2);

        $manager->flush();
    }
}
