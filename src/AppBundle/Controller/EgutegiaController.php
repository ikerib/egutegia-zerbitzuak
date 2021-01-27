<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Calendar controller.
 *
 * @Route("egutegia")
 */
class EgutegiaController extends Controller
{
    /**
     * Lists all calendar entities.
     *
     * @Route("/{username}", name="egutegia_user")
     * @Method("GET")
     *
     * @param mixed $username
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function useregutegiaAction($username)
    {
        $em = $this->getDoctrine()->getManager();
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsername($username);

        return $this->render('egutegia/user_egutegia.html.twig', [
            'calendar' => $calendar,
            'username' => $username,
        ]);
    }
}
