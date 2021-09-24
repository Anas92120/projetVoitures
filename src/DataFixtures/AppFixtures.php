<?php

namespace App\DataFixtures;

use App\Entity\TypeVoiture;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

       $typevoiture1 = new TypeVoiture();
       $typevoiture1->setLibelle('routiere');
       $manager->persist($typevoiture1);

       $typevoiture2 = new TypeVoiture();
       $typevoiture2->setlibelle('4x4');
       $manager->persist($typevoiture2);

        $voiture1 = new Voiture();
        $voiture1->setCouleur('Noir')
        ->setMarque('Audi')
        ->setIdTypeVoiture($typevoiture1);
        $manager->persist($voiture1);

        $voiture2 = new Voiture();
        $voiture2->setCouleur('Rouge')
            ->setMarque('Mercedes-Benz')
            ->setIdTypeVoiture($typevoiture2);
        $manager->persist($voiture2);

        $voiture3 = new Voiture();
        $voiture3->setCouleur('Rouge')
            ->setMarque('Mercedes-Benz')
            ->setIdTypeVoiture($typevoiture1);
        $manager->persist($voiture3);

        $manager->flush();
    }
}
