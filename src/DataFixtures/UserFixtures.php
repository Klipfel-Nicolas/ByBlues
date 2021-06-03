<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $nbIterations = 6;

        for ($i = 1; $i <= $nbIterations; $i++) {
            $user = new User();
            $user->setMail($faker->email())
                ->setVerifiedMail(1)
                ->setRole('bye bluers')
                ->setFirstName($faker->firstName(null))
                ->setLastName($faker->lastName());

            $manager->persist($user);
        }
        $manager->flush();
    }
}
