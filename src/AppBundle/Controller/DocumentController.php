<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\Log;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Document controller.
 *
 * @Route("admin/document")
 */
class DocumentController extends Controller
{

    /**
     * Order up
     *
     * @Route("/up/{id}", name="admin_document_order_up")
     * @Method("GET")
     */
    public function upAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Document $doc */
        $doc = $em->getRepository('AppBundle:Document')->find($id);

        if (!$doc) {
            throw new EntityNotFoundException();
        }

        /** @var Calendar $calendar */
        $calendar = $doc->getCalendar();

        $newOrden = $doc->getOrden() - 1;

        if ( $newOrden < 0 ) {
            $newOrden = 0;
        }
        $doc->setOrden( $newOrden );
        $em->persist( $doc);

        /** @var Log $log */
        $log = new Log();
        $log->setName('Fitxategia ordena gora');
        $log->setDescription($doc->getFilename() . " fitxategiaren ordena orain da: " . $newOrden);
        $em->persist($log);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#files'
        );


    }

    /**
     * Order down
     *
     * @Route("/down/{id}", name="admin_document_order_down")
     * @Method("GET")
     */
    public function downAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Document $doc */
        $doc = $em->getRepository('AppBundle:Document')->find($id);

        if (!$doc) {
            throw new EntityNotFoundException();
        }

        /** @var Calendar $calendar */
        $calendar = $doc->getCalendar();

        $doc->setOrden( $doc->getOrden() + 1 );
        $em->persist( $doc);

        /** @var Log $log */
        $log = new Log();
        $log->setName('Fitxategia behera gora');
        $log->setDescription($doc->getFilename() . " fitxategiaren ordena orain da: " . $doc->getOrden());
        $em->persist($log);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#files'
        );
    }

    /**
     * Lists all document entities.
     *
     * @Route("/", name="admin_document_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $documents = $em->getRepository('AppBundle:Document')->findAll();

        return $this->render(
            'document/index.html.twig',
            [
                'documents' => $documents,
            ]
        );
    }

    /**
     * Lists all User documents.
     *
     * @Route("/list/{calendarid}", name="admin_user_document_list")
     * @Method("GET")
     *
     * @param $calendarid
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($calendarid)
    {
        $em = $this->getDoctrine()->getManager();

        $documents = $em->getRepository('AppBundle:Document')->findCalendarDocuments($calendarid);

        return $this->render(
            'document/list.html.twig',
            [
                'documents' => $documents,
            ]
        );
    }

    /**
     * Creates a new document entity.
     *
     * @Route("/new/{calendarid}", name="admin_document_new")
     * @Method({"GET", "POST"})
     *
     * @param Request    $request
     * @param null|mixed $calendarid
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws EntityNotFoundException
     */
    public function newAction(Request $request, $calendarid = null)
    {
        $em = $this->getDoctrine()->getManager();
        $calendar = $em->getRepository('AppBundle:Calendar')->find($calendarid);

        if (!$calendar) {
            throw new EntityNotFoundException();
        }

        $document = new Document();
        $document->setCalendar($calendar);
        $form = $this->createForm(
            'AppBundle\Form\DocumentType',
            $document,
            ['action' => $this->generateUrl('admin_document_new', ['calendarid' => $calendarid])]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($document);

            /** @var Log $log */
            $log = new Log();
            $log->setCalendar($calendar);
            $log->setUser($this->getUser());
            $log->setName('Fitxategi berria');
            $log->setDescription($document->getFilename().' fitxategia sortua izan da.');
            $em->persist($log);

            $em->flush();

            //return $this->redirectToRoute( 'admin_calendar_edit', array( 'id' => $calendarid ) );
            return $this->redirect(
                $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#files'
            );
        }

        return $this->render(
            'document/new.html.twig',
            [
                'document' => $document,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing document entity.
     *
     * @Route("/{id}/edit", name="admin_document_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm('AppBundle\Form\DocumentType', $document);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_document_edit', ['id' => $document->getId()]);
        }

        return $this->render(
            'document/edit.html.twig',
            [
                'document' => $document,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a document entity.
     *
     * @Route("/{id}", name="admin_document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Document $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);

        $calendar = $document->getCalendar();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);

            /** @var Log $log */
            $log = new Log();
            $log->setCalendar($calendar);
            $log->setUser($this->getUser());
            $log->setName('Fitxategia ezabatua');
            $log->setDescription($document->getFilename().' fitxategia ezabatua izan da.');
            $em->persist($log);

            $em->flush();
        }

        //return $this->redirectToRoute( 'admin_document_index' );
        //return $this->redirectToRoute('admin_calendar_edit',array('id' => $calendar->getId()));

        return $this->redirect(
            $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#files'
        );
    }

    /**
     * Creates a form to delete a document entity.
     *
     * @param Document $document The document entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Document $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_document_delete', ['id' => $document->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
