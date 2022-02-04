<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Type;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $i = 0;
        for ($i; $i < 15; $i++){
            $type = new Type();
            $type
                ->setGenre($faker->word(15));
            $manager->persist($type);
        }

        $manager->flush();
    }
}
