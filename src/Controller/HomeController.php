<?php

namespace App\Controller;

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
