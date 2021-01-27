<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/admin/message", name="admin_message_list", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $q       = $request->query->get('q');

        if (($q === null) || ($q === 'all')) {
            $messages = $em->getRepository('AppBundle:Message')->getAllMessages();
        } else {
            $messages = $em->getRepository('AppBundle:Message')->findByParameter($q);
        }

        return $this->render('message/index.html.twig', array(
            'messages' => $messages,
        ));
    }


    /**
     * @Route("/admin/message/{id}", name="admin_message_delete", methods={"DELETE"})
     * @param Request $request
     * @param Message $message
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Message $message): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_message_list');
    }
}
