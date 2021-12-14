<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Services\Slugify;

class Articlefixtures extends Fixture implements DependentFixtureInterface
{

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $iteration = 15;
        for ($i = 0; $i < $iteration; $i++) {
            $article = new Article();

            $article->setContent($faker->text);
            $article->setTitle($faker->sentence(7, true));
            $slug = $this->slugify->generate($article->getTitle());
            $article->setSlug($slug);
            $article->setAuthor($this->getReference('User_' . $i));
            $article->setPoster(
                "bougie.jpg"
            );
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
