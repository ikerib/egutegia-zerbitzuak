<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hour;
use AppBundle\Entity\Log;
use AppBundle\Entity\User;
use AppBundle\Form\CalendarNoteType;
use AppBundle\Form\CalendarType;
use AppBundle\Form\DocumentType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LdapTools\Exception\EmptyResultException;
use LdapTools\Exception\MultiResultException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Calendar controller.
 *
 * @Route("admin/calendar")
 */
class CalendarController extends Controller
{
    /**
     * Lists all calendar entities.
     *
     * @Route("/", name="admin_calendar_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $calendars = $em->getRepository('AppBundle:Calendar')->findAll();

        return $this->render(
            'calendar/index.html.twig',
            [
                'calendars' => $calendars,
            ]
        );
    }

    /**
     * Creates a new calendar entity.
     *
     * @Route("/new/{username}", name="admin_calendar_new", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param mixed   $username
     *
     * @return RedirectResponse|Response
     * @throws EmptyResultException
     * @throws MultiResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function newAction(Request $request, $username = '')
    {
        /** @var EntityManager $em */
        $em       = $this->getDoctrine()->getManager();
        $year     = date('Y');
        $calendar = new Calendar();
        $calendar->setYear($year);

        if ($username !== '') {
            $user = $em->getRepository('AppBundle:User')->findOneBy(
                [
                    'username' => $username,
                ]
            );
            $calendar->setUser($user);
        }
        $year = (new DateTime())->format('Y');
        $calendar->setName($username.' - '.$year);

        $lastYear     = $year - 1;
        $lastCalendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($username, $lastYear);

        $form = $this->createForm(
            CalendarType::class,
            $calendar,
            [
                'action'   => $this->generateUrl('admin_calendar_new'),
                'method'   => 'POST',
                'username' => $username,
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* Check if User exist in our app */
            $username = $form->get('username')->getData();

            $u = $em->getRepository('AppBundle:User')->getByUsername($username);

            if (!$u) {
                $ldap     = $this->get('ldap_tools.ldap_manager');
                $ldapuser = $ldap->buildLdapQuery()
                                 ->select(['name', 'guid', 'username', 'emailAddress', 'firstName', 'lastName', 'dn', 'department', 'description'])
                                 ->fromUsers()
                                 ->where($ldap->buildLdapQuery()->filter()->eq('username', $username))
                                 ->orderBy('username')
                                 ->getLdapQuery()
                                 ->getSingleResult();

                $userManager = $this->container->get('fos_user.user_manager');
                /** @var $user User */
                $user = $userManager->createUser();
                $user->setUsername($username);
                $user->setEmail($username.'@pasaia.net');
                $user->setPassword('');
                if ($ldapuser->has('dn')) {
                    $user->setDn($ldapuser->getDn());
                }
                $user->setEnabled(true);
                if ($ldapuser->has('description')) {
                    $user->setLanpostua($ldapuser->getDescription());
                }
                if ($ldapuser->has('department')) {
                    $user->setDepartment($ldapuser->getDepartment());
                }

                $userManager->updateUser($user);
                $u = $user;
            }
            $calendar->setUser($u);
            $em->persist($calendar);

            /** @var Log $log */
            $log = new Log();
            $log->setName('Egutegia sortu');
            $log->setDescription($calendar->getName().' egutegia sortua izan da');
            $log->setCalendar($calendar);
            //$log->setUser( $this->getUser() );
            $em->persist($log);

            $em->flush($calendar);

            return $this->redirectToRoute('admin_calendar_edit', ['id' => $calendar->getId()]);
        }

        if (count($lastCalendar) == 0) {
            $azkenEgutegi = null;
        } else {
            $azkenEgutegi = $lastCalendar[ 0 ];
        }


        if ($request->isXmlHttpRequest()) {
            return $this->render(
                'calendar/_ajax_new.html.twig',
                [
                    'calendar'     => $calendar,
                    'username'     => $username,
                    'lastCalendar' => $azkenEgutegi,
                    'form'         => $form->createView(),
                ]
            );
        }

        return $this->render(
            'calendar/new.html.twig',
            [
                'calendar' => $calendar,
                'username' => $username,
                'form'     => $form->createView(),
            ]
        );
    }

    /**
     * Finds and displays a calendar entity.
     *
     * @Route("/{id}", name="admin_calendar_show", methods={"GET"})
     * @param Calendar $calendar
     *
     * @return Response
     */
    public function showAction(Calendar $calendar): Response
    {
        $deleteForm = $this->createDeleteForm($calendar);

        return $this->render(
            'calendar/show.html.twig',
            [
                'calendar'    => $calendar,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing calendar entity.
     *
     * @Route("/{id}/edit", name="admin_calendar_edit", methods={"GET", "POST"})
     *
     * @param Request       $request
     * @param Calendar|null $calendar
     *
     * @return Response
     */
    public function editAction(Request $request, Calendar $calendar = null): Response
    {
        if ($calendar === null) {
            $this->addFlash('danger', 'Ez da egutegia topatu');

            return $this->redirectToRoute('dashboard');
        }
        $deleteForm = $this->createDeleteForm($calendar);
        $editForm   = $this->createForm(
            CalendarType::class,
            $calendar,
            [
                'action' => $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]),
                'method' => 'POST',
            ]
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_calendar_edit', ['id' => $calendar->getId()]);
        }

        $em = $this->getDoctrine()->getManager();

        $logs = $em->getRepository('AppBundle:Log')->findCalendarLogs($calendar->getId());

        $types = $em->getRepository('AppBundle:Type')->findAll();

        $frmnote = $this->createForm(
            CalendarNoteType::class,
            $calendar
        );

        $doc = new Document();
        $doc->setCalendar($calendar);
        $frmFile = $this->createForm(
            DocumentType::class,
            $doc
        );

        $documents           = $calendar->getDocuments();
        $deleteDocumentForms = [];
        foreach ($documents as $doc) {
            $deleteDocumentForms[ $doc->getId() ] = $this->createDocumentDeleteForm($doc)->createView();
        }

        $hours            = $calendar->getHours();
        $deleteHoursForms = [];
        foreach ($hours as $h) {
            $deleteHoursForms[ $h->getId() ] = $this->createHourDeleteForm($h)->createView();
        }


        // norberarentzako orduak
        /** @var Event $selfHours */
        $selfHours         = $em->getRepository('AppBundle:Event')->findCalendarSelfEvents($calendar->getId());
        $selfHoursPartial  = 0;
        $selfHoursComplete = 0;

        foreach ($selfHours as $s) {
            /** @var Event $s */
            if ($s->getHours() < $calendar->getHoursDay()) {
                $selfHoursPartial += (float)$s->getHours();
            } else {
                $selfHoursComplete += (float)$s->getHours();
            }
        }

//        $selfHoursPartial = round($calendar->getHoursSelfHalf() - $selfHoursPartial,2);
        $selfHoursPartial = round($calendar->getHoursSelfHalf(), 2);
//        $selfHoursComplete = round( $calendar->getHoursSelf() - (float) $selfHoursComplete,2);
        $selfHoursComplete = round($calendar->getHoursSelf(), 2);

        return $this->render(
            'calendar/edit.html.twig',
            [
                'calendar'            => $calendar,
                'orduak'              => $calendar->getHours(),
                'edit_form'           => $editForm->createView(),
                'delete_form'         => $deleteForm->createView(),
                'frmnote'             => $frmnote->createView(),
                'frmfile'             => $frmFile->createView(),
                'logs'                => $logs,
                'types'               => $types,
                'deletedocumentforms' => $deleteDocumentForms,
                'deletehourforms'     => $deleteHoursForms,
                'selfHoursPartial'    => $selfHoursPartial,
                'selfHoursComplete'   => $selfHoursComplete,
            ]
        );
    }

    /**
     * Deletes a calendar entity.
     *
     * @Route("/{id}", name="admin_calendar_delete", methods={"DELETE"})
     *
     * @param Request  $request
     * @param Calendar $calendar
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Calendar $calendar): RedirectResponse
    {
        $form = $this->createDeleteForm($calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendar);
            $em->flush();
        }

        return $this->redirectToRoute('dashboard');
    }

    /**
     * Creates a form to delete a calendar entity.
     *
     * @param Calendar $calendar The calendar entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Calendar $calendar)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_calendar_delete', ['id' => $calendar->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Creates a form to delete a calendar entity.
     *
     * @param Document $doc The calendar entity
     *
     * @return Form|FormInterface
     */
    private function createDocumentDeleteForm(Document $doc)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_document_delete', ['id' => $doc->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Creates a form to delete a Hour entity.
     *
     * @param Hour $h The calendar entity
     *
     * @return Form|FormInterface
     */
    private function createHourDeleteForm(Hour $h)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_hour_delete', ['id' => $h->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }


}
