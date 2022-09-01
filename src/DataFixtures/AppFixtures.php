<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $race = new Race();
        $race->setraceName('Utrka Makarska');      
        $race->setDate(new \DateTime()); 
        $manager->persist($race);
        $manager->flush();
    }
}