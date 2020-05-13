<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Classe;
use App\Entity\Comment;
use App\Entity\Eleve;
use App\Entity\Event;
use App\Entity\EventCategory;
use App\Entity\Tag;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $titles = ['Sport', 'Actualité', 'Automobile', 'Gastronomie'];
        $tags = [];
        foreach ($titles as $title) {
            $tag = new Tag;
            $tag->setTitle($title);
            $manager->persist($tag);
            $tags[] = $tag;
        }
        for ($c = 0; $c < 4; $c++) {
            $category = new Category;
            $category->setTitle($faker->catchPhrase);
            $manager->persist($category);
            for ($i = 0; $i < 20; $i++) {
                $post = new Post();
                $post
                    ->setTitle($faker->catchPhrase)
                    ->setContent($faker->paragraphs(5, true))
                    ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                    ->setCategory($category)
                    ->setImage($faker->imageUrl(500, 500, true));
                for ($t = 0; $t < mt_rand(0, 4); $t++) {
                    $comment = new Comment;
                    $comment->setAuthor($faker->userName);
                    $comment->setContent($faker->paragraphs(2, true));
                    $comment->setCreatedAt($faker->dateTimeBetween('-6 month'));
                    $comment->setPost($post);
                    $manager->persist($comment);
                }

                $postTags = $faker->randomElements($tags, mt_rand(0, 3));
                foreach ($postTags as $tag) {
                    $post->addTag($tag);
                }

                $manager->persist($post);
            }
        }
        $eventCategory1 = new EventCategory;
        $eventCategory1->setName('Concert');
        $eventCategory1->setCreatedAt($faker->dateTimeBetween('-6 month'));
        $manager->persist($eventCategory1);
        for ($i = 0; $i < 10; $i++) {
            $event = new Event;
            $event
                ->setTitle($faker->catchPhrase)
                ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                ->setTime($faker->dateTimeBetween('-6 month'))
                ->setEventCategory($eventCategory1)
                ->setPlace($faker->city)
                ->setDescription($faker->paragraphs(3, true))
                ->setImage($faker->imageUrl(500, 500, true));
            $manager->persist($event);
        }

        $eventCategory2 = new EventCategory;
        $eventCategory2->setName('Theâtre');
        $eventCategory2->setCreatedAt($faker->dateTimeBetween('-6 month'));
        $manager->persist($eventCategory2);
        for ($i = 0; $i < 10; $i++) {
            $event = new Event;
            $event
                ->setTitle($faker->catchPhrase)
                ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                ->setTime($faker->dateTimeBetween('-6 month'))
                ->setEventCategory($eventCategory2)
                ->setPlace($faker->city)
                ->setDescription($faker->paragraphs(3, true))
                ->setImage($faker->imageUrl(500, 500, true));
            $manager->persist($event);
        }

        $classes = ['CP', 'CE1', 'CE2', 'CM1', 'CM2'];
        foreach ($classes as $classe) {
            $entityClasse = new Classe;
            $entityClasse
                ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                ->setName($classe);
            $manager->persist($entityClasse);
            for ($i = 0; $i < 15; $i++) {
                $entityEleve = new Eleve;
                $entityEleve->setFirstName($faker->firstName());
                $entityEleve->setLastName($faker->lastName());
                $entityEleve->setCreatedAt($faker->dateTimeBetween('-6 month'));
                $entityEleve->setClasse($entityClasse);
                $manager->persist($entityEleve);
            }
        }


        $manager->flush();
    }
}
