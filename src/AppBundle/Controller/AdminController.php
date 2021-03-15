<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Saila;
use AppBundle\Entity\User;
use AppBundle\Form\UserNoteType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     *
     * @return Response
     *
     * @internal param Request $request
     */
    public function dashboardAction(): Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $sailaRol=null;
        foreach ($this->getUser()->getRoles() as $rol) {
            if (strpos($rol, 'WEB_EGUTEGIA_ZERBITZUAK' ) > 0) {
                $sailaRol = $rol;
            }
        }

        if ($sailaRol === null) {
            $users = $em->getRepository('AppBundle:User')->findAll();
        } else {
            /** @var Saila $sailak */
            $sailak = $em->getRepository('AppBundle:Saila')->findUsersBySailaRoles($sailaRol);
            if ($sailak)
            {
                /** @var Saila $saila */
                $saila = $sailak[0];
                $users = $saila->getUser();
            }

            $sailaName = '';
            /** @var User $logedUser */
            $logedUser = $this->getUser();
            /** @var Saila $logedUserSaila */
            $logedUserSaila = $logedUser->getSaila();
            if ( $logedUserSaila) {
                $sailaName = $logedUserSaila->getName();
            }

            return $this->render(
                'default/sailaindex.html.twig',
                [
                    'saila' => $sailaName,
                    'userdata' => $users
                ]
            );
        }


//        $userdata = [];
//        foreach ($users as $user) {
//            /** @var $user User */
//            $u = [];
//            $u['user'] = $user;
//            $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
//                $user->getUsername(),
//                date('Y')
//            );
//            $u['calendar'] = $calendar;
//
//            $egutegiguztiak = $em->getRepository('AppBundle:Calendar')->findAllCalendarsByUsername($user->getUsername());
//            $u[ 'egutegiak' ] = $egutegiguztiak;
//
//            /** @var $usernotes User */
//            $usernotes = $em->getRepository('AppBundle:User')->getByUsername($user->getUsername());
//
//            if ($usernotes) {
//                $user->setNotes($usernotes->getNotes());
//            }
//            $userdata[] = $u;
//        }

        $user = new User();
        $frmusernote = $this->createForm(UserNoteType::class, $user);

        return $this->render(
            'default/index.html.twig',
            [
                'userdata' => $users,
                'frmusernote' => $frmusernote->createView(),
            ]
        );
    }



}
