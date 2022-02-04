<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
        $i = 0;
        for ($i; $i < 15; $i++){
            $category = new Category();
            $category
                ->setName($faker->word(15));
            $manager->persist($category);
        }


        $manager->flush();
    }
}
