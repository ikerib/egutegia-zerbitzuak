<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Firma;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Firma controller.
 *
 * @Route("admin/firm")
 */
class FirmaController extends Controller
{
    /**
     * Lists all firma entities.
     *
     * @Route("/", name="admin_firma_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $firmas = $em->getRepository('AppBundle:Firma')->findAll();

        return $this->render('firma/index.html.twig', array(
            'firmas' => $firmas,
        ));
    }

    /**
     * Creates a new firma entity.
     *
     * @Route("/new", name="admina_firm_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $firma = new Firma();
        $form = $this->createForm('AppBundle\Form\FirmaType', $firma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firma);
            $em->flush();

            return $this->redirectToRoute('admin_firm_show', array('id' => $firma->getId()));
        }

        return $this->render('firma/new.html.twig', array(
            'firma' => $firma,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a firma entity.
     *
     * @Route("/{id}", name="admin_firma_show")
     * @Method("GET")
     */
    public function showAction(Firma $firma)
    {
        $deleteForm = $this->createDeleteForm($firma);

        return $this->render('firma/show.html.twig', array(
            'firma' => $firma,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing firma entity.
     *
     * @Route("/{id}/edit", name="admin_firma_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Firma $firma)
    {
        $deleteForm = $this->createDeleteForm($firma);
        $editForm = $this->createForm('AppBundle\Form\FirmaType', $firma);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_firm_edit', array('id' => $firma->getId()));
        }

        return $this->render('firma/edit.html.twig', array(
            'firma' => $firma,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a firma entity.
     *
     * @Route("/{id}", name="admin_firma_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Firma $firma)
    {
        $form = $this->createDeleteForm($firma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($firma);
            $em->flush();
        }

        return $this->redirectToRoute('admin_firm_index');
    }

    /**
     * Creates a form to delete a firma entity.
     *
     * @param Firma $firma The firma entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Firma $firma)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_firm_delete', array('id' => $firma->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
