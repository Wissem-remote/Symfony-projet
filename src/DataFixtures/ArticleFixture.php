<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixture extends Fixture  implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article->setName("Drone-V1");
        $article->setNombre(2);
        $article->setDescription("Fantastique drone");
        $manager->persist($article);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['article'];
    }
}
