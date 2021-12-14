<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TagFixtures extends Fixture
{
    public const TAG = [
        'bébé',
        'dépression',
        'pré-natal',
        'nuit calme',
        'luminothérapie'
    ];

    /**
     * @Param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::TAG); $i++) {
            $tag = new Tag();

            $tag->setIntitule(self::TAG[$i]);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}
