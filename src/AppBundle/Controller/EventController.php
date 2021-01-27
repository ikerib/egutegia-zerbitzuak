<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\EventType;

/**
 * Event controller.
 *
 * @Route("admin/event")
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="admin_event_index")
     * @Method("GET")
     */
    public function indexAction(): \Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="admin_event_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('admin_event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="admin_event_show")
     * @Method("GET")
     * @param Event $event
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Event $event): \Symfony\Component\HttpFoundation\Response
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="admin_event_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Event   $event
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm(EventType::class, $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_event_edit', ['id' => $event->getId()]);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="admin_event_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Event   $event
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Event $event): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('admin_event_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_event_delete', ['id' => $event->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
