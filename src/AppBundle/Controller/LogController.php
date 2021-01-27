<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Log controller.
 *
 * @Route("admin/log")
 */
class LogController extends Controller
{
    /**
     * Lists all log entities.
     *
     * @Route("/", name="admin_log_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $logs = $em->getRepository('AppBundle:Log')->findLoginlogs();

        return $this->render('log/index.html.twig', array(
            'logs' => $logs,
        ));
    }
}
