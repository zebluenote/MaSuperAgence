<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $faker = Factory::create('fr_FR');
      for ($i=0; $i < 1000; $i++) {
        $property = new Property();
        $property
          ->setTitle($faker->words(3, true))
          ->setDescription($faker->sentences(3, true))
          ->setSurface($faker->numberBetween(20,350))
          ->setRooms($faker->numberBetween(1,12))
          ->setBedrooms($faker->numberBetween(1,8))
          ->setFloor($faker->numberBetween(0,10))
          ->setPrice($faker->numberBetween(100000,3000000))
          ->setHeat($faker->numberBetween(0, count(Property::HEAT)-1))
          ->setCity($faker->city)
          ->setAddress($faker->address)
          ->setPostalCode($faker->postcode)
          ->setSold(false);
        $manager->persist($property);
      }
      $manager->flush();
    }
}
