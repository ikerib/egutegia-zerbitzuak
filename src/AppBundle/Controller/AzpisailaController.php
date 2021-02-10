<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Azpisaila;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AzpisailaType;

/**
 * Azpisaila controller.
 *
 * @Route("admin/azpisaila")
 */
class AzpisailaController extends Controller
{
    /**
     * Lists all azpisaila entities.
     *
     * @Route("/", name="admin_azpisaila_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $azpisailak = $em->getRepository('AppBundle:Azpisaila')->findAll();
        $deleteForms = [];
        /** @var Azpisaila $azpisaila */
        foreach ($azpisailak as $azpisaila) {
            $deleteForms[$azpisaila->getId()] = $this->createDeleteForm($azpisaila)->createView();
        }

        return $this->render('azpisaila/index.html.twig', array(
            'azpisailak' => $azpisailak,
            'deleteforms'   => $deleteForms
        ));
    }

    /**
     * Creates a new azpisaila entity.
     *
     * @Route("/new", name="admin_azpisaila_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $azpisaila = new Azpisaila();
        $form = $this->createForm(AzpisailaType::class, $azpisaila,
            [
                'action' => $this->generateUrl('admin_azpisaila_new'),
                'method' => 'POST'
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpisaila);
            $em->flush();

            return $this->redirectToRoute('admin_azpisaila_index');
        }

        return $this->render('azpisaila/new.html.twig', array(
            'azpisaila' => $azpisaila,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing azpisaila entity.
     *
     * @Route("/{id}/edit", name="admin_azpisaila_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Azpisaila $azpisaila)
    {
        $deleteForm = $this->createDeleteForm($azpisaila);
        $editForm = $this->createForm('AppBundle\Form\AzpisailaType', $azpisaila);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_azpisaila_index');
        }

        return $this->render('azpisaila/edit.html.twig', array(
            'azpisaila' => $azpisaila,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a azpisaila entity.
     *
     * @Route("/{id}", name="admin_azpisaila_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Azpisaila $azpisaila)
    {
        $form = $this->createDeleteForm($azpisaila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($azpisaila);
            $em->flush();
        }

        return $this->redirectToRoute('admin_azpisaila_index');
    }

    /**
     * Creates a form to delete a azpisaila entity.
     *
     * @param Azpisaila $azpisaila The azpisaila entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Azpisaila $azpisaila)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_azpisaila_delete', array('id' => $azpisaila->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
