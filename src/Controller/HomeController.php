<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController
{

    /**
     * @Route("/", name="home")
     */
    public function index(Environment $twig): Response
    {
        $html = $twig->render('home.html.twig');
        return new Response($html);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(EntityManagerInterface $em, PostRepository $repository)
    {
        // Pour modifier un post :
        // $post = $repository->find(2);
        // $post->setTitle('Nouveau titre');
        // $em->flush();

        //Pour créer un post :
        // $post = new Post();
        // $post
        //     ->setTitle('Mon premier article')
        //     ->setContent('Mon super contenu d\'article')
        //     ->setCreatedAt(new DateTime());
        // $em->persist($post);
        // $em->flush();

        //Pour supprimer un post :
        // $post = $repository->find(1);
        // $em->remove($post);
        // $em->flush();

        // dd($post);
    }

    /**
     * @Route("/hello/{name?World}", name="hello")
     */
    public function hello(string $name, Environment $twig): Response
    {
        $prenoms = ['lior', 'gaspard', 'elise'];
        $formateur = ['prenom' => 'Lior', 'nom' => 'Chamla'];
        $eleves = [
            ['prenom' => 'Renaud', 'nom' => 'Bordet'],
            ['prenom' => 'Gaspard', 'nom' => 'Doussière'],
            ['prenom' => 'Ania', 'nom' => 'Attouchi'],
            ['prenom' => 'Xavier', 'nom' => 'Vitali']
        ];
        $html = $twig->render('hello.html.twig', [
            'prenom'     => $name,
            'prenoms'    => $prenoms,
            'formateur'  => $formateur,
            'eleves'     => $eleves
        ]);
        return new Response($html);
    }
}
