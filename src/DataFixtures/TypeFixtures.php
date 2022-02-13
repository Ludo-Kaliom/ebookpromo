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
            array('genre' => 'Roman', 'status' => '1'),
            array('genre' => 'Recueil de nouvelles', 'status' => '1'),
            array('genre' => 'Anthologie', 'status' => '1'),
            array('genre' => 'Roman court', 'status' => '1'),
            array('genre' => 'Nouvelle', 'status' => '1'),
            array('genre' => 'Recueil de poésies', 'status' => '1'),
            array('genre' => 'Magazine numérique', 'status' => '1'),
            array('genre' => 'Livre audio', 'status' => '0'),
            array('genre' => 'Nawak', 'status' => '0'),
        );
        
        foreach($tab as $row)
        {
          $type = new Type();
          $type->setGenre($row['genre']);
          $type->setStatus($row['status']);
        
          $manager->persist($type);
          $manager->flush();
        }
    }
}
