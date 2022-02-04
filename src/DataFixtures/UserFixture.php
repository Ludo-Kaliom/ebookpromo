<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
        $i = 0;
        for ($i; $i < 30; $i++){
            $user = new User();
            $user
                ->setUsername($faker->name)
                ->setEmail($faker->email)
                ->setPassword($faker->word(20))
                ->setAvatar($faker->imageUrl($width = 150, $height = 150))
                ->setRegistrationdate($faker->dateTime($max = 'now'))
                ->setUpdated($faker->dateTime($max = 'now'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
