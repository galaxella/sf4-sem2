<?php

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class NotesFixtures extends BaseFixture  implements DependentFixtureInterface //BaseFixtures appelle Fixtures
{
    public function loadData()
    {
        //Création des Fixtures
        $this->createMany(10,'note', function () {
            return (new Note())
                ->setValue($this->faker->numberBetween($min = 1, $max = 10))
                ->setComment($this->faker->optional()->realText())
                ->setCreatedAt($this->faker->dateTime())
                ->setRecord($this->getRandomReference('record'))
                ->setAuthor($this->getRandomReference('user'))

                ;
        });
    }

    /**
     * Permet de signaler que le chargement de cette fixture ne peut pas se faire avant d' avoir fait d' autres fixtures
     * (en l' occurrence Record et User) puisqu' il existe des liens entre les différentes Entities
    */
    public function getDependencies()
    {
        return [
            RecordFixtures::class,
            UserFixtures::class
        ];
    }

}
