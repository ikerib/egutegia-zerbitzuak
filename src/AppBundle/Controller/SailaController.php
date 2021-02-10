<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Saila;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SailaType;

/**
 * Saila controller.
 *
 * @Route("admin/saila")
 */
class SailaController extends Controller
{
    /**
     * Lists all saila entities.
     *
     * @Route("/", name="admin_saila_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sailak = $em->getRepository('AppBundle:Saila')->findAll();

        $deleteForms = [];
        /** @var Saila $saila */
        foreach ($sailak as $saila) {

            $deleteForms[$saila->getId()] = $this->createDeleteForm($saila)->createView();
        }

        return $this->render('saila/index.html.twig', array(
            'sailak' => $sailak,
            'deleteForms'   => $deleteForms
        ));
    }

    /**
     * Creates a new saila entity.
     *
     * @Route("/new", name="admin_saila_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $saila = new Saila();
        $form = $this->createForm(SailaType::class, $saila, [
            'action' => $this->generateUrl('admin_saila_new'),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($saila);
            $em->flush();

            return $this->redirectToRoute('admin_saila_index');
        }

        return $this->render('saila/new.html.twig', array(
            'saila' => $saila,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing saila entity.
     *
     * @Route("/{id}/edit", name="admin_saila_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Saila $saila)
    {
        $deleteForm = $this->createDeleteForm($saila);
        $editForm = $this->createForm('AppBundle\Form\SailaType', $saila);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_saila_index');
        }

        return $this->render('saila/edit.html.twig', array(
            'saila' => $saila,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a saila entity.
     *
     * @Route("/{id}", name="admin_saila_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Saila $saila)
    {
        $form = $this->createDeleteForm($saila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($saila);
            $em->flush();
        }

        return $this->redirectToRoute('admin_saila_index');
    }

    /**
     * Creates a form to delete a saila entity.
     *
     * @param Saila $saila The saila entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Saila $saila)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_saila_delete', array('id' => $saila->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
