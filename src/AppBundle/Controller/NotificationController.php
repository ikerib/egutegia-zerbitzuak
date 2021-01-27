<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{

    /**
     * Lists all notification entities.
     *
     * @Route("/", name="notification_index")
     * @Method("GET")
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        /**
         * Parametroak baditu hauek izan daitezke:
         * -1 Irakurri gabe
         * 0 Guztiak
         * 1 Irakurritakoak
         */
        $em   = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $q = $request->query->get('q');

        if ($q === null) {
            $q = null;
        }

        $notifications = $em->getRepository('AppBundle:Notification')->getCurrentUserNotifications($user->getId(), $q);

        return $this->render(
            'notification/index.html.twig',
            array(
                'notifications' => $notifications,
                'user'          => $user,
            )
        );
    }

    /**
     * Lists all notification entities for everyone. Only ROLE_SUPER_ADMIN
     *
     * @Route("/sinatzen", name="notification_sinatzen")
     * @Method("GET")
     * @param Request $request
     *
     * @return Response
     */
    public function sinatzenAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $q = $request->query->get('q');

        if ($q === null) {
            $q = null;
        }

        $notifications = $em->getRepository('AppBundle:Notification')->getCurrentUserNotifications($user->getId(), $q);


        return $this->render(
            'notification/sinatzen.html.twig',
            array(
                'notifications' => $notifications
            )
        );
    }


    /**
     * Lists all notification entities for everyone. Only ROLE_SUPER_ADMIN
     *
     * @Route("/list", name="notification_list")
     * @Method("GET")
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        /**
         * Parametroak baditu hauek izan daitezke:
         * -1 Irakurri gabe
         * 0 Guztiak
         * 1 Irakurritakoak
         */
        $em = $this->getDoctrine()->getManager();

        $q = $request->query->get('q');

        if ($q === null) {
            $q = null;
        }

        $notifications = $em->getRepository('AppBundle:Notification')->getAllUserNotifications($q);

        $deleteForms = [];
        foreach ($notifications as $notify) {
            /** @var Notification $notify */
            $deleteForms[ $notify->getId() ] = $this->createDeleteForm($notify)->createView();
        }

        return $this->render(
            'notification/list.html.twig',
            array(
                'notifications' => $notifications,
                'deleteforms'   => $deleteForms,
            )
        );
    }


    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{id}", name="notification_show")
     * @Method("GET")
     * @param Notification $notification
     *
     * @return Response
     */
    public function showAction(Notification $notification)
    {
        return $this->render(
            'notification/show.html.twig',
            array(
                'notification' => $notification,
            )
        );
    }

    /**
     * Deletes a type entity.
     *
     * @Route("/{id}", name="notification_delete")
     * @Method("DELETE")
     * @param Request      $request
     * @param Notification $notify
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Notification $notify)
    {
        $form = $this->createDeleteForm($notify);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notify);
            $em->flush();
        }

        return $this->redirectToRoute('notification_list');
    }

    /**
     * Creates a form to delete a type entity.
     *
     * @param Notification $notify The type entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Notification $notify)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('notification_delete', ['id' => $notify->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * @Route("/readed/{id}", name="notification_readed")
     * @param              $id
     * @param Notification $notification
     *
     * @return RedirectResponse
     */
    public function setReadedAction(Notification $notification)
    {
        $em = $this->getDoctrine()->getManager();
        $notification->setReaded(1);
        $notification->setResult(1);
        $notification->setCompleted(1);
        $notification->setSinatzeprozesua( 0 );

        $em->persist($notification);
        $em->flush();

        return $this->redirectToRoute('notification_index', ['q' => 'unanswered']);
    }
}
