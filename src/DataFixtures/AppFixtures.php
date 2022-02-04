<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $generator = \Faker\Factory::create();
        $populator = new \Faker\ORM\Propel\Populator($generator);
        $populator->addEntity(Book::class, 100);
        $insertedPKs = $populator->execute();

        $manager->persist($insertedPKs);
        $manager->flush();
    }
}
