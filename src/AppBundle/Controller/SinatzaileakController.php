<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sinatzaileak;
use AppBundle\Entity\Sinatzaileakdet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\SinatzaileakType;

/**
 * Sinatzaileak controller.
 *
 * @Route("admin/sinatzaileak")
 */
class SinatzaileakController extends Controller
{
    /**
     * Lists all sinatzaileak entities.
     *
     * @Route("/", name="admin_sinatzaileak_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sinatzaileaks = $em->getRepository('AppBundle:Sinatzaileak')->findAll();

        $deleteForms = [];
        foreach ($sinatzaileaks as $e) {
            /** @var Sinatzaileak $e */
            $deleteForms[ $e->getId() ] = $this->createDeleteForm($e)->createView();
        }

        return $this->render('sinatzaileak/index.html.twig', array(
            'sinatzaileaks' => $sinatzaileaks,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new sinatzaileak entity.
     *
     * @Route("/new", name="admin_sinatzaileak_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sinatzaileak = new Sinatzaileak();
        $form = $this->createForm('AppBundle\Form\SinatzaileakType', $sinatzaileak, [
            'action' => $this->generateUrl('admin_sinatzaileak_new'),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sinatzaileak);
            $em->flush();

            return $this->redirectToRoute('admin_sinatzaileak_show', array('id' => $sinatzaileak->getId()));
        }

        return $this->render('sinatzaileak/new.html.twig', array(
            'sinatzaileak' => $sinatzaileak,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sinatzaileak entity.
     *
     * @Route("/{id}", name="admin_sinatzaileak_show")
     * @Method("GET")
     * @param Sinatzaileak $sinatzaileak
     *
     * @return Response
     */
    public function showAction(Sinatzaileak $sinatzaileak): Response
    {
        $deleteForm = $this->createDeleteForm($sinatzaileak);

        $deleteForms = [];
        /** @var Sinatzaileakdet $sd */
        $sd = $sinatzaileak->getSinatzaileakdet();
        foreach ($sd as $s) {
            /** @var Sinatzaileakdet $s */
            $deleteForms[$s->getId()] = $this->createDeleteFormSinatzaileakkDet($s)->createView();
        }

        return $this->render('sinatzaileak/show.html.twig', array(
            'sinatzaileak' => $sinatzaileak,
            'delete_form' => $deleteForm->createView(),
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Displays a form to edit an existing sinatzaileak entity.
     *
     * @Route("/{id}/edit", name="admin_sinatzaileak_edit")
     * @Method({"GET", "POST"})
     * @param Request      $request
     * @param Sinatzaileak $sinatzaileak
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Sinatzaileak $sinatzaileak)
    {
        $deleteForm = $this->createDeleteForm($sinatzaileak);
        $editForm = $this->createForm(SinatzaileakType::class, $sinatzaileak);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sinatzaileak_index');
        }

        return $this->render('sinatzaileak/edit.html.twig', array(
            'sinatzaileak' => $sinatzaileak,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sinatzaileak entity.
     *
     * @Route("/{id}", name="admin_sinatzaileak_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sinatzaileak $sinatzaileak)
    {
        $form = $this->createDeleteForm($sinatzaileak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sinatzaileak);
            $em->flush();
        }

        return $this->redirectToRoute('admin_sinatzaileak_index');
    }

    /**
     * Creates a form to delete a sinatzaileak entity.
     *
     * @param Sinatzaileak $sinatzaileak The sinatzaileak entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Sinatzaileak $sinatzaileak)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sinatzaileak_delete', array('id' => $sinatzaileak->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a sinatzaileakdet entity.
     *
     * @param Sinatzaileakdet $sd
     *
     * @return Form The form
     *
     */
    private function createDeleteFormSinatzaileakkDet(Sinatzaileakdet $sd)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sinatzaileakdet_delete', array('id' => $sd->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
