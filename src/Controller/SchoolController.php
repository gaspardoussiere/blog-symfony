<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SchoolController extends AbstractController
{
    /**
     * @Route("/school", name="school")
     */
    public function index(EleveRepository $eleveRepository)
    {
        $eleves =  $eleveRepository->findBy([], ['createdAt' => 'DESC'], 20);
        // dd($eleves);
        return $this->render('school/index.html.twig', [
            'eleves' => $eleves
        ]);
    }

    /**
     * @Route("/admin/school/create", name="school_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $eleveForm = $this->createForm(EleveType::class);
        $eleveForm->handleRequest($request);
        if ($eleveForm->isSubmitted() && $eleveForm->isValid()) {
            /**@var \App\Entity\Eleve */
            $eleve = $eleveForm->getData();
            $eleve->setCreatedAt(new DateTime());
            $em->persist($eleve);
            $em->flush();
            // dd('redirectooo');
            return $this->redirectToRoute('school');
        }
        $view = $eleveForm->createView();
        return $this->render('school/create.html.twig', [
            'eleveForm' => $view
        ]);
    }

    /**
     * @Route("/admin/school/delete/{id}", name="school_delete")
     */
    public function delete(Eleve $eleve, EntityManagerInterface $em)
    {

        $em->remove($eleve);
        $em->flush();

        return $this->redirectToRoute('school');
    }
}
