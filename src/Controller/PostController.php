<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/blog", name="post")
     */
    public function index(PostRepository $postRepository)
    {
        $posts =  $postRepository->findBy([], ['createdAt' => 'DESC'], 10);
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/blog/{id}", name="post_show")
     */
    public function show(Post $post, Request $request, EntityManagerInterface $em)
    {
        // $post = $postRepository->find($id);
        // if (!$post) {
        //     throw $this->createNotFoundException();
        // }

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**@var \App\Entity\Comment */
            $comment = $form->getData();
            $comment
                ->setCreatedAt(new DateTime())
                ->setPost($post);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/create", name="post_create")
     */
    public function create(Request $request, EntityManagerInterface $em, UrlGeneratorInterface $generator)
    {
        $form = $this->createForm(PostType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**@var \App\Entity\Post */
            $post = $form->getData();
            $post->setCreatedAt(new DateTime());
            $em->persist($post);
            $em->flush();

            // I - Façon "fait main" mais désuète :
            // $response = new Response();
            // $response->setStatusCode(302);
            // $response->headers->set('Location', '/blog/' . $post->getId());
            // return $response;
            // II - Façon "avec héritage" :
            // $url = $generator->generate('post_show', [
            //     'id' => $post->getId()
            // ]);
            // $response = new RedirectResponse($url);
            // return $response;
            // III Façon usuelle en une ligne :

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        $view = $form->createView();
        return $this->render('post/create.html.twig', [
            'postForm' => $view
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="post_edit")
     */
    public function edit(Post $post, Request $request, EntityManagerInterface $em)
    {
        // $repo = $em->getRepository(Post::class);
        // $post = $postRepository->find($id);
        // if (!$post) {
        //     throw $this->createNotFoundException();
        // }
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Pas nécéssaire :
            // $post = $form->getData();
            $em->flush();
            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }
        return $this->render('post/edit.html.twig', [
            'postForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="post_delete")
     */
    public function delete(Post $post, EntityManagerInterface $em)
    {
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('post');
    }
}
