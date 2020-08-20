<?php

namespace App\DataFixtures;

use App\Entity\Label;
use App\Entity\Record;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LabelFixtures extends baseFixture
{
    protected function loadData()
    {
        $this->createMany(10, 'label',function (){
           return(new Label())
               ->setName($this->faker->lastName . 'Productions')
               ;
        });
    }



}
