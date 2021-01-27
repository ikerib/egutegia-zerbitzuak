<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 7/03/18
 * Time: 10:35
 */

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * Stores the locale of the user in the session after the
 * login. This can be used by the LocaleSubscriber afterwards.
 */
class UserLocaleSubscriber implements EventSubscriberInterface
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        if (null !== $user->getHizkuntza()) {
            $this->session->set('_locale', strtolower($user->getHizkuntza()));
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => array(array('onInteractiveLogin', 15)),
        );
    }
}