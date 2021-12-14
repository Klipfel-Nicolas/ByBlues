<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ItemFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create(('fr_FR'));

        $iteration = 3;

        for ($i = 0; $i < $iteration; $i++) {
            $item = new Item();

            $item->setDescription($faker->text);
            $item->setName($faker->sentence(3, true));
            $item->setPrice($faker->randomFloat(2, 30, 190));
            $item->setQuantityAviable($faker->numberBetween(10, 150));
            $item->setDisplayPerDay($faker->numberBetween(9, 1500));
            $item->setIsPreOrder("true|false");
            $manager->persist($item);
        }

        $manager->flush();
    }
}
