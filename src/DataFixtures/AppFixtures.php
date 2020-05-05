<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post
                ->setTitle("Article n°$i")
                ->setContent("Contenu de l'article n°$i")
                ->setCreatedAt(new DateTime());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
