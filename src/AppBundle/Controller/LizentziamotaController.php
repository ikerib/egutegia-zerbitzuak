<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lizentziamota;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\LizentziamotaType;

/**
 * Lizentziamotum controller.
 *
 * @Route("admin/lizentziamota")
 */
class LizentziamotaController extends Controller
{
    /**
     * Lists all lizentziamotum entities.
     *
     * @Route("/", name="admin_lizentziamota_index")
     * @Method("GET")
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $lizentziamotas = $em->getRepository('AppBundle:Lizentziamota')->findAll();

        $deleteForms = [];
        foreach ($lizentziamotas as $lize) {
            $deleteForms[$lize->getId()] = $this->createDeleteForm($lize)->createView();
        }

        return $this->render('lizentziamota/index.html.twig', array(
            'lizentziamotas' => $lizentziamotas,
            'deleteforms' => $deleteForms,
        ));
    }

    /**
     * Creates a new lizentziamotum entity.
     *
     * @Route("/new", name="admin_lizentziamota_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $lizentziamotum = new Lizentziamota();
        $form = $this->createForm(
            LizentziamotaType::class,
            $lizentziamotum,
            [
                'action' => $this->generateUrl('admin_lizentziamota_new'),
                'method' => 'POST',
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lizentziamotum);
            $em->flush();

            return $this->redirectToRoute('admin_lizentziamota_index');
        }

        return $this->render('lizentziamota/new.html.twig', array(
            'lizentziamotum' => $lizentziamotum,
            'form' => $form->createView(),
        ));
    }


    /**
     * Deletes a lizentziamotum entity.
     *
     * @Route("/{id}", name="admin_lizentziamota_delete")
     * @Method("DELETE")
     * @param Request       $request
     * @param Lizentziamota $lizentziamotum
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Lizentziamota $lizentziamotum): RedirectResponse
    {
        $form = $this->createDeleteForm($lizentziamotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lizentziamotum);
            $em->flush();
        }

        return $this->redirectToRoute('admin_lizentziamota_index');
    }

    /**
     * Displays a form to edit an existing lizentziamotum entity.
     *
     * @Route("/{id}/edit", name="admin_lizentziamota_edit")
     * @Method({"GET", "POST"})
     * @param Request       $request
     * @param Lizentziamota $lizentziamotum
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Lizentziamota $lizentziamotum)
    {
        $deleteForm = $this->createDeleteForm($lizentziamotum);
        $editForm = $this->createForm(LizentziamotaType::class, $lizentziamotum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_lizentziamota_index');
        }

        return $this->render('lizentziamota/edit.html.twig', array(
            'lizentziamotum' => $lizentziamotum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Creates a form to delete a lizentziamotum entity.
     *
     * @param Lizentziamota $lizentziamotum The lizentziamotum entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Lizentziamota $lizentziamotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_lizentziamota_delete', array('id' => $lizentziamotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;


    }
}
