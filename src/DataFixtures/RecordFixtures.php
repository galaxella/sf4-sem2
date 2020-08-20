<?php

namespace App\DataFixtures;

use App\Entity\Record;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecordFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData()
    {
       $this->createMany(100, 'record', function (){
           return(new Record())
               ->setTitle($this->faker->catchPhrase)
               ->setDescription($this->faker->optional()->realText())
               ->setReleasedAt($this->faker->dateTimeBetween('-2years'))
               ->setArtist($this->getRandomReference('artist'))

               ->setLabel($this->faker->boolean(75)  ? $this->getRandomReference('label') : null)//faker genere moi un boolean
               ;

    });
    }

    public function getDependencies()
    {
     return [
         ArtistFixtures::class
     ];
    }


}
