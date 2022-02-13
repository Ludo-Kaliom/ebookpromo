<?php

namespace App\DataFixtures;

use App\Entity\Subcategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubcategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tab = array(
            array('name' => 'Romantique', 'status' => '1'),
            array('name' => 'Historique', 'status' => '1'),
            array('name' => 'Paranormale', 'status' => '1'),
            array('name' => 'Dark Fantasy', 'status' => '1'),
            array('name' => 'Post-Apo', 'status' => '1'),
        );
        
        foreach($tab as $row)
        {
          $subcategory = new Subcategory();
          $subcategory->setName($row['name']);
          $subcategory->setStatus($row['status']);
        
          $manager->persist($subcategory);
          $manager->flush();
        }
    }
}
