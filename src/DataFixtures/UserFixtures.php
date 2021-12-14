<?php

namespace App\DataFixtures;

use App\Services\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use App\Entity\User;

class UserFixtures extends Fixture
{

     private $passwordHasher;

    public function __construct(UserPasswordEncoderInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $sluggy = new Slugify();
        $iteration = 15;

        for ($i = 0; $i <= $iteration; $i++) {
            $user = new User();
            $firstname = $faker->firstName(null);
            $user->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setAdress1($faker->streetAddress())
                ->setAdress2($faker->city())
                ->setPassword($this->passwordHasher->encodePassword($user, $faker->word()))
                ->setFirstName($firstname)
                ->setLastName($faker->lastName())
                ->setSlug($sluggy->generate($firstname))
                ->setIsVerified(0);

                $manager->persist($user);
                $this->addReference('User_' . $i, $user);
        }

        $manager->flush();
    }
}
