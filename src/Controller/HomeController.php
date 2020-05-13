<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        // $html = $this->twig->render('home.html.twig');
        // return new Response($html);
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/test/{id}", name="test")
     */
    public function test(EntityManagerInterface $em, PostRepository $repository, CategoryRepository $categoryRepository, $id)
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


        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException();
        }
        $posts = $category->getPosts();
        // dump(count($posts));
        // dd($category);
        // $post = $repository->find('24');
        // $category = $post->getCategory();
        // dump($category->getTitle());
        // dd($post);

        // $html =  $this->twig->render('category.html.twig', [
        //     'category' => $category
        // ]);
        // return new Response($html);

        return $this->render('category.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/hello/{name?World}", name="hello")
     */
    public function hello(string $name): Response
    {
        $prenoms = ['lior', 'gaspard', 'elise'];
        $formateur = ['prenom' => 'Lior', 'nom' => 'Chamla'];
        $eleves = [
            ['prenom' => 'Renaud', 'nom' => 'Bordet'],
            ['prenom' => 'Gaspard', 'nom' => 'Doussière'],
            ['prenom' => 'Ania', 'nom' => 'Attouchi'],
            ['prenom' => 'Xavier', 'nom' => 'Vitali']
        ];
        return $this->render('hello.html.twig', [
            'prenom'     => $name,
            'prenoms'    => $prenoms,
            'formateur'  => $formateur,
            'eleves'     => $eleves
        ]);
    }
}
