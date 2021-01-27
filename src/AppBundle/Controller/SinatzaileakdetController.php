<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sinatzaileakdet;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Sinatzaileakdet controller.
 *
 * @Route("admin/sinatzaileakdet")
 */
class SinatzaileakdetController extends Controller
{
    /**
     * Lists all sinatzaileakdet entities.
     *
     * @Route("/", name="admin_sinatzaileakdet_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $sinatzaileakdets = $em->getRepository('AppBundle:Sinatzaileakdet')->findAll();

        return $this->render('sinatzaileakdet/index.html.twig', array(
            'sinatzaileakdets' => $sinatzaileakdets,
        ));
    }

    /**
     * Creates a new sinatzaileakdet entity.
     *
     * @Route("/new/{sinatzaileid}", name="admin_sinatzaileakdet_new", methods={"GET", "POST"})
     * @param Request $request
     * @param         $sinatzaileid
     *
     * @return RedirectResponse|Response
     * @throws EntityNotFoundException
     */
    public function newAction(Request $request, $sinatzaileid)
    {
        $em = $this->getDoctrine()->getManager();
        $sina = $em->getRepository('AppBundle:Sinatzaileak')->find($sinatzaileid);
        if (!$sina) {
            throw new EntityNotFoundException('Ez da sinatzaile zerrenda topatu');
        }
        $sinatzaileakdet = new Sinatzaileakdet();
        $sinatzaileakdet->setSinatzaileak($sina);
        $form = $this->createForm('AppBundle\Form\SinatzaileakdetType', $sinatzaileakdet, [
            'action' => $this->generateUrl('admin_sinatzaileakdet_new', array('sinatzaileid' => $sina->getId())),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sinatzaileakdet);
            $em->flush();

            //return $this->redirectToRoute('admin_sinatzaileakdet_show', array('id' => $sinatzaileakdet->getId()));
            return $this->redirectToRoute('admin_sinatzaileak_show', array('id' => $sina->getId()));
        }

        return $this->render('sinatzaileakdet/new.html.twig', array(
            'sinatzaileakdet' => $sinatzaileakdet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sinatzaileakdet entity.
     *
     * @Route("/{id}/show", name="admin_sinatzaileakdet_show", methods={"GET"})
     * @param Sinatzaileakdet $sinatzaileakdet
     *
     * @return Response
     */
    public function showAction(Sinatzaileakdet $sinatzaileakdet)
    {
        $deleteForm = $this->createDeleteForm($sinatzaileakdet);

        return $this->render('sinatzaileakdet/show.html.twig', array(
            'sinatzaileakdet' => $sinatzaileakdet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sinatzaileakdet entity.
     *
     * @Route("/{id}/edit", name="admin_sinatzaileakdet_edit", methods={"GET", "POST"})
     * @param Request         $request
     * @param Sinatzaileakdet $sinatzaileakdet
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Sinatzaileakdet $sinatzaileakdet)
    {
        $deleteForm = $this->createDeleteForm($sinatzaileakdet);
        $editForm = $this->createForm('AppBundle\Form\SinatzaileakdetType', $sinatzaileakdet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sinatzaileakdet_edit', array('id' => $sinatzaileakdet->getId()));
        }

        return $this->render('sinatzaileakdet/edit.html.twig', array(
            'sinatzaileakdet' => $sinatzaileakdet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sinatzaileakdet entity.
     *
     * @Route("/{id}", name="admin_sinatzaileakdet_delete", methods={"DELETE"})
     * @param Request         $request
     * @param Sinatzaileakdet $sinatzaileakdet
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Sinatzaileakdet $sinatzaileakdet)
    {
        $form = $this->createDeleteForm($sinatzaileakdet);
        $form->handleRequest($request);

        $miid = $sinatzaileakdet->getSinatzaileak()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sinatzaileakdet);
            $em->flush();
        }

        //return $this->redirectToRoute('admin_sinatzaileakdet_index');
        return $this->redirectToRoute('admin_sinatzaileak_show', array('id' => $miid));
    }

    /**
     * Creates a form to delete a sinatzaileakdet entity.
     *
     * @param Sinatzaileakdet $sinatzaileakdet The sinatzaileakdet entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Sinatzaileakdet $sinatzaileakdet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sinatzaileakdet_delete', array('id' => $sinatzaileakdet->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Orden up
     *
     * @Route("/{id}/up", options={"expose"=true}, name="admin_sinatzaileakdet_up", methods={"GET"})
     * @param Sinatzaileakdet $sinatzaileakdet
     * @return RedirectResponse
     */
    public function upAction(Sinatzaileakdet $sinatzaileakdet)
    {
        $em = $this->getDoctrine()->getManager();
        $sinatzaileakdet->setOrden(
            $sinatzaileakdet->getOrden() - 1
        );
        $em->persist($sinatzaileakdet);
        $em->flush();

        return $this->redirectToRoute('admin_sinatzaileak_show', array('id' => $sinatzaileakdet->getSinatzaileak()->getId()));
    }

    /**
     * Orden down
     *
     * @Route("/{id}/down", options={"expose"=true}, name="admin_sinatzaileakdet_down", methods={"GET"})
     * @param Sinatzaileakdet $sinatzaileakdet
     * @return RedirectResponse
     */
    public function downAction(Sinatzaileakdet $sinatzaileakdet)
    {
        $em = $this->getDoctrine()->getManager();
        $sinatzaileakdet->setOrden(
            $sinatzaileakdet->getOrden() + 1
        );
        $em->persist($sinatzaileakdet);
        $em->flush();

        return $this->redirectToRoute('admin_sinatzaileak_show', array('id' => $sinatzaileakdet->getSinatzaileak()->getId()));
    }
}
