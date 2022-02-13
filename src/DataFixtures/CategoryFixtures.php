<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tab = array(
            array('name' => 'Fantasy', 'status' => '1'),
            array('name' => 'Fantastique', 'status' => '1'),
            array('name' => 'Science-fiction', 'status' => '1'),
            array('name' => 'Horreur', 'status' => '1'),
            array('name' => 'Multigenre', 'status' => '0'),
        );
        
        foreach($tab as $row)
        {
          $category = new Category();
          $category->setName($row['name']);
          $category->setStatus($row['status']);
        
          $manager->persist($category);
          $manager->flush();
        }
    }
}
