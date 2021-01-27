<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Firmadet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Firmadet controller.
 *
 * @Route("erantzunak")
 */
class FirmadetController extends Controller
{
    /**
     * Lists all firmadet entities.
     *
     * @Route("/", name="erantzunak_index")
     * @Method("GET")
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $firmadets = $em->getRepository('AppBundle:Firmadet')->bilatuDenak();

        return $this->render(
            'firmadet/index.html.twig',
            array(
                'firmadets' => $firmadets,
            )
        );
    }

    /**
     * Creates a new firmadet entity.
     *
     * @Route("/new", name="erantzunak_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $firmadet = new Firmadet();
        $form     = $this->createForm('AppBundle\Form\FirmadetType', $firmadet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firmadet);
            $em->flush();

            return $this->redirectToRoute('erantzunak_show', array('id' => $firmadet->getId()));
        }

        return $this->render(
            'firmadet/new.html.twig',
            array(
                'firmadet' => $firmadet,
                'form'     => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a firmadet entity.
     *
     * @Route("/{id}", name="erantzunak_show")
     * @Method("GET")
     */
    public function showAction(Firmadet $firmadet)
    {
        $deleteForm = $this->createDeleteForm($firmadet);

        return $this->render(
            'firmadet/show.html.twig',
            array(
                'firmadet'    => $firmadet,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing firmadet entity.
     *
     * @Route("/{id}/edit", name="erantzunak_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Firmadet $firmadet)
    {
        $deleteForm = $this->createDeleteForm($firmadet);
        $editForm   = $this->createForm('AppBundle\Form\FirmadetType', $firmadet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('erantzunak_edit', array('id' => $firmadet->getId()));
        }

        return $this->render(
            'firmadet/edit.html.twig',
            array(
                'firmadet'    => $firmadet,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a firmadet entity.
     *
     * @Route("/{id}", name="erantzunak_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Firmadet $firmadet)
    {
        $form = $this->createDeleteForm($firmadet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($firmadet);
            $em->flush();
        }

        return $this->redirectToRoute('erantzunak_index');
    }

    /**
     * Creates a form to delete a firmadet entity.
     *
     * @param Firmadet $firmadet The firmadet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Firmadet $firmadet)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('erantzunak_delete', array('id' => $firmadet->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
