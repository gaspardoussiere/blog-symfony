<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventCategory;
use App\Form\EventType;
use App\Repository\EventRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EventController extends AbstractController
{
    /**
     * @Route("/event", name="show_events")
     */
    public function indexEvent(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();
        // dd($events);
        return $this->render('event/index.html.twig', [
            'events' => $events
        ]);
    }


    /**
     * @Route("/event/{id<\d+>}", name="event_show")
     */
    public function showEvent(EventRepository $eventRepository)
    {
        $event = $eventRepository->find($id);
        if (!$event) {
            throw $this->createNotFoundException();
        }
        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
    }

    /**
     * @Route("/admin/event/create", name="event_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setCreatedAt(new DateTime());
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
        }
        $view = $form->createView();
        return $this->render('event/create.html.twig', [
            'eventForm' => $view
        ]);
    }

    /**
     * @Route("/admin/event/delete/{id}", name="event_delete")
     */
    public function delete(EventRepository $eventRepository, EntityManagerInterface $em)
    {
        $event = $eventRepository->find($id);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('show_events');
    }
}
