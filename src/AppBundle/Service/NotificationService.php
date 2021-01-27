<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 5/31/17
 * Time: 8:41 AM
 */

namespace AppBundle\Service;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Notification;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NotificationService
{
    protected $u;
    protected $em;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->u = $tokenStorage->getToken()->getUser();
    }

    public function GetNotifications()
    {
        /** @var User $user */
        $user = $this->u;

        $notifications = $this->em->getRepository('AppBundle:Notification')->getAllUnCompleted($user->getId());

        return $notifications;
    }

    public function sendNotificationToFirst($eskaera, $firma, $lehenSinatzaile): void
    {
        $notify = new Notification();
        $notify->setName('Eskaera berria sinatzeke: '.$eskaera->getUser()->getDisplayname());
        $desc = '';
        /** @var Eskaera $eskaera */
        if ($eskaera->getLizentziamota()) {
            if ($eskaera->getLizentziamota()->getSinatubehar() === false) {
                $notify->setName('Lizentzia: '.$eskaera->getUser()->getDisplayname());
                $notify->setSinatzeprozesua(false);
                $desc = $eskaera->getUser()->getDisplayname()." langilearen lizentziaren jakinarazpena.\n".
                    'Egutegia: '.$eskaera->getCalendar()->getName().'\n'.
                    'Hasi: '.$eskaera->getHasi()->format('Y-m-d').'\n';
            } else {
                $notify->setSinatzeprozesua(true);
                $desc = $eskaera->getUser()->getDisplayname()." langilearen eskaera berria daukazu sinatzeke.\n".
                    'Egutegia: '.$eskaera->getCalendar()->getName().'\n'.
                    'Hasi: '.$eskaera->getHasi()->format('Y-m-d').'\n';
            }
        }

        if ($eskaera->getAmaitu() !== null) {
            $desc .= 'Amaitu: '.$eskaera->getAmaitu()->format('Y-m-d');
        }

        $notify->setDescription($desc);
        $notify->setEskaera($eskaera);
        if ($firma) {
            $notify->setFirma($firma);
        }

        $notify->setUser($lehenSinatzaile->getUser());
        $this->em->persist($notify);
        $this->em->flush();
    }
}
