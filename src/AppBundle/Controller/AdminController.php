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
use DateTime;
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

        if ( ($sailaRol === null) || ($this->isGranted('ROLE_BIDERATZAILEA')) ){
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

    /**
     * @Route("/kuadrantea", name="admin_kuadrantea")
     *
     * @return Response
     *
     * @internal param Request $request
     */
    public function kuadranteaAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('AppBundle:Kuadrantea')->getAllOrderByYearAndUserDisplayName();

        $year = date('Y');
        // urteko lehen astea bada, aurreko urtea aukeratu
        $date_now = new DateTime();
        $date2    = new DateTime("06/01/".$year);

        if ($date_now <= $date2) {
            --$year;
        }
        return $this->render('default/kuadrantea.html.twig', [
            'results' => $results,
            'year' => $year
        ]);
    }

    /**
     * @Route("/kuadranteaexcel", name="admin_kuadrantea_excel")
     *
     * @return Response
     *
     * @internal param Request $request
     */
    public function kuadranteaExcelAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('AppBundle:Kuadrantea')->getAllOrderByYearAndUserDisplayName();

        $year = date('Y');
        // urteko lehen astea bada, aurreko urtea aukeratu
        $date_now = new DateTime();
        $date2    = new DateTime("06/01/".$year);

        if ($date_now <= $date2) {
            --$year;
        }

        $writer = $this->container->get('egyg33k.csv.writer');
        $csv = $writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Urtea','Hilabetea', 'Langilea', 'Lanpostua','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']);
        foreach ($results as $result) {
            $csv->insertOne([
                $result->getUrtea(),
                $result->getHilabetea(),
                $result->getUser()->getDisplayName(),
                $result->getUser()->getDepartment(),
                $result->getDay01(),
                $result->getDay02(),
                $result->getDay03(),
                $result->getDay04(),
                $result->getDay05(),
                $result->getDay06(),
                $result->getDay07(),
                $result->getDay08(),
                $result->getDay09(),
                $result->getDay10(),
                $result->getDay11(),
                $result->getDay12(),
                $result->getDay13(),
                $result->getDay14(),
                $result->getDay15(),
                $result->getDay16(),
                $result->getDay17(),
                $result->getDay18(),
                $result->getDay19(),
                $result->getDay20(),
                $result->getDay21(),
                $result->getDay22(),
                $result->getDay23(),
                $result->getDay24(),
                $result->getDay25(),
                $result->getDay26(),
                $result->getDay27(),
                $result->getDay28(),
                $result->getDay29(),
                $result->getDay30(),
                $result->getDay31()
            ]);
        }
        $csv->output('kuadrantea.csv');
        exit;
//        return $this->render('default/kuadrantea.html.twig', [
//            'results' => $results,
//            'year' => $year
//        ]);
    }


    /**
     * @Route ("/print/{id}", name="print_calendar")
     */
    public function printCalendarAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $calendar = $em->getRepository('AppBundle:Calendar')->find($id);

        return $this->render('default/calendar_print.html.twig', [
            'calendar' => $calendar
        ]);
    }
}
