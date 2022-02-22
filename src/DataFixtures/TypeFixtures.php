<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $tab = array(
            array('name' => 'Roman', 'status' => '1'),
            array('name' => 'Recueil de nouvelles', 'status' => '1'),
            array('name' => 'Anthologie', 'status' => '1'),
            array('name' => 'Roman court', 'status' => '1'),
            array('name' => 'Nouvelle', 'status' => '1'),
            array('name' => 'Recueil de poésies', 'status' => '1'),
            array('name' => 'Magazine numérique', 'status' => '1'),
            array('name' => 'Livre audio', 'status' => '0'),
            array('name' => 'Nawak', 'status' => '0'),
        );
        
        foreach($tab as $row)
        {
          $type = new Type();
          $type->setName($row['name']);
          $type->setStatus($row['status']);
        
          $manager->persist($type);
          $manager->flush();
        }
    }
}
