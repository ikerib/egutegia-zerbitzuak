<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Template;
use AppBundle\Entity\TemplateEvent;
use AppBundle\Form\TemplateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Template controller.
 *
 * @Route("admin/template")
 */
class TemplateController extends Controller
{
    /**
     * Lists all template entities.
     *
     * @Route("/", name="admin_template_index")
     * @Method("GET")
     */
    public function indexAction(): \Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();

        $templates = $em->getRepository('AppBundle:Template')->findAll();

        $deleteForms = [];
        foreach ($templates as $template) {
            /* var $template Template */
            $deleteForms[$template->getId()] = $this->createDeleteForm($template)->createView();
        }

        return $this->render(
            'template/index.html.twig',
            [
                'templates' => $templates,
                'deleteforms' => $deleteForms,
            ]
        );
    }

    /**
     * Creates a new template entity.
     *
     * @Route("/new", name="admin_template_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $template = new Template();
        $form = $this->createForm(
            TemplateType::class,
            $template,
            [
                'action' => $this->generateUrl('admin_template_new'),
                'method' => 'POST',
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            return $this->redirectToRoute('admin_template_edit', ['id' => $template->getId()]);
        }

        return $this->render(
            'template/new.html.twig',
            [
                'template' => $template,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Finds and displays a template entity.
     *
     * @Route("/{id}", name="admin_template_show")
     * @Method("GET")
     *
     * @param Template $template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Template $template): \Symfony\Component\HttpFoundation\Response
    {
        $deleteForm = $this->createDeleteForm($template);

        return $this->render(
            'template/show.html.twig',
            [
                'template' => $template,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing template entity.
     *
     * @Route("/{id}/edit", name="admin_template_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request  $request
     * @param Template $template
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);
        $editForm = $this->createForm(TemplateType::class, $template);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('AppBundle:Type')->findAll();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_template_edit', ['id' => $template->getId()]);
        }

        return $this->render(
            'template/edit.html.twig',
            [
                'template' => $template,
                'types' => $types,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     *
     * @Route("/{id}/copy", name="admin_template_copy")
     * @Method({"GET"})
     *
     * @param Request  $request
     * @param Template $template
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function copyAction(Request $request, Template $template)
    {
        $em = $this->getDoctrine()->getManager();
        $t = new Template();
        $t->setName($template->getName() . '-kopia');
        $t->setHoursCompensed($template->getHoursCompensed());
        $t->setHoursDay($template->getHoursDay());
        $t->setHoursFree($template->getHoursFree());
        $t->setHoursSelf($template->getHoursSelf());
        $t->setHoursYear($template->getHoursYear());
        $t->setSlug($template->getSlug());

        /** @var TemplateEvent $templateEvent */
        foreach ($template->getTemplateEvents() as $templateEvent) {
            $te = new TemplateEvent();
            $te->setName($templateEvent->getName());
            $te->setEndDate($templateEvent->getEndDate());
            $te->setStartDate($templateEvent->getStartDate());
            $te->setTemplate($t);
            $te->setType($templateEvent->getType());
            $em->persist($te);
        }

        $em->persist($t);
        $em->flush();

        return $this->redirectToRoute('admin_template_edit', ['id' => $t->getId()]);

    }

    /**
     * Deletes a template entity.
     *
     * @Route("/{id}", name="admin_template_delete")
     * @Method("DELETE")
     *
     * @param Request  $request
     * @param Template $template
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Template $template): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $form = $this->createDeleteForm($template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($template);
            $em->flush();
        }

        return $this->redirectToRoute('admin_template_index');
    }

    /**
     * Creates a form to delete a template entity.
     *
     * @param Template $template The template entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Template $template)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_template_delete', ['id' => $template->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
