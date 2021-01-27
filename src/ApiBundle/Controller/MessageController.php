<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Form\MessageType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageController extends AbstractFOSRestController
{
    public function getMessagesAction(): View
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->findAll();

        $ctx = new Context();
        $ctx->addGroup('main');
        return View::create($messages, Response::HTTP_OK)->setContext($ctx);
    }

    public function getMessageAction($id): View
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Message')->find($id);

        $ctx = new Context();
        $ctx->addGroup('main');
        return View::create($message, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Post(options={"expose": true})
     * @param Request $request
     *
     * @return View
     */
    public function postMessagesAction(Request $request): View
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            //            $data = $form->getData();
            $formUsers = $request->request->get('appbundle_message');


            // begiratu eta zenbat pertsoneri zuzendua dagoen
            // utsik = denak
            if (array_key_exists('user', $formUsers) === false) {
                $allUsers = $em->getRepository('AppBundle:User')->findAll();
                foreach ($allUsers as $u) {
                    /** @var Message $m */
                    $m = new Message();
                    $m->setUser($u);
                    $m->setName($message->getName());
                    $m->setDescription($message->getDescription());
                    $em->persist($m);
                }
            } elseif (count($formUsers[ 'user' ]) > 0) {
                // Erabiltzaile bat baina gehiago
                foreach ($formUsers[ 'user' ] as $u) {
                    $us = $em->getRepository('AppBundle:User')->find($u);
                    /** @var Message $m */
                    $m = new Message();
                    $m->setUser($us);
                    $m->setName($message->getName());
                    $m->setDescription($message->getDescription());
                    $em->persist($m);
                }
            } else {
                $em->persist($message);
            }
            $em->flush();
            $ctx = new Context();
            $ctx->addGroup('main');
            return View::create($message, Response::HTTP_OK)->setContext($ctx);
        }
        return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }


    public function deleteMessagesAction($id): View
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Message $message */
        $msg = $em->getRepository('AppBundle:Message')->find($id);
        $em->remove($msg);
        $em->flush();

        return View::create(null, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/messages/new/nouser", name="messages_new", options={"expose": true})
     * @return Response
     */
    public function getMessagesNewAction(): Response
    {
        $msg = new Message();
        $form   = $this->createForm(MessageType::class, $msg);

        return $this->render('message/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Rest\Get(options={"expose": true})
     * @param $id
     *
     * @return Response
     */
    public function getMessagesNewUserAction($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($id);
        if (!$user) {
            throw  new NotFoundHttpException('User not found.');
        }
        $msg = new Message();
        $msg->setUser($user);
        $form   = $this->createForm(MessageType::class, $msg);

        return $this->render('message/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
