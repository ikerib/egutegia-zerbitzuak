<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 11/8/18
 * Time: 2:23 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Entity\Type;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CalendarService
{
    protected $u;
    protected $em;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->u = $tokenStorage->getToken()->getUser();
    }

    /**
     * @param $datuak
     *               calendar_id (required) [int]
     *               type_id (required)  [int]
     *               event_name (required)  [string]
     *               event_start (required)  [datetime]
     *               event_fin (required) [datetime]
     *               event_hours (required) [float]
     *               event_nondik
     *               event_hours_self_before
     *               event_hours_self_half_before
     *
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function addEvent($datuak): array
    {
        /** @var Calendar $calendar */
        $calendar = $this->em->getRepository('AppBundle:Calendar')->find($datuak['calendar_id']);
        /** @var Type $type */
        $type = $this->em->getRepository('AppBundle:Type')->find($datuak['type_id']);
        /** @var Event $event */
        $event = new Event();

        $event->setCalendar( $calendar );
        $event->setName($datuak[ 'event_name' ]);
        $event->setStartDate($datuak[ 'event_start' ]);
        $event->setEndDate($datuak[ 'event_fin' ]);
        $event->setHours($datuak[ 'event_hours' ]);
        $event->setType($type);

        if (array_key_exists('event_nondik', $datuak) && array_key_exists('event_hours_self_before', $datuak) && array_key_exists(
                'event_hours_self_half_before',
                $datuak
            ) && $type->getId() === 5) {
                $event->setNondik( $datuak[ 'event_nondik' ] );
                $event->setHoursSelfBefore( $datuak[ 'event_hours_self_before' ] );
                $event->setHoursSelfHalfBefore( $datuak[ 'event_hours_self_half_before' ] );
        }

        $this->em->persist($event);

        if ( $type->getRelated() ) {
            /** @var Type $t */
            $t = $event->getType();
            if ( $t->getRelated() === 'hours_free' ) {
                $calendar->setHoursFree( (float)$calendar->getHoursFree() - (float)$datuak[ 'event_hours' ]);
            }
            if ( $t->getRelated() === 'hours_self' ) {

                /**
                 * 1-. Begiratu eskatuta orduak jornada bat baino gehiago direla edo berdin,
                 * horrela bada hours_self-etik kendu bestela ordueta hours_self_half
                 */
                $jornada = floatval( $calendar->getHoursDay() );
                $orduak  = floatval( $datuak[ 'event_hours' ] );
                $nondik  = $datuak[ 'event_nondik' ];

                $partziala           = 0;
                $egunOsoaOrduak      = 0;
                $egutegiaOrduakTotal = floatval( $calendar->getHoursSelf() ) + floatval( $calendar->getHoursSelfHalf() );


                if ( $nondik === 'orduak') {
                    // Begiratu nahiko ordu dituen
                    if ( $calendar->getHoursSelfHalf() >= $orduak ) {
                        $partziala = $calendar->getHoursSelfHalf();
                    } else {
                        $resp = array(
                            'result' => -1,
                            'text'   => 'Ez ditu nahikoa ordu.',
                        );

                        return $resp;
                    }

                } else {
                    // Begiratu nahiko ordu dituen Egunetan
                    // Eskatutako ordu adina edo gehiago baditu
                    if ( $calendar->getHoursSelf() >= $orduak ) {
                        $egunOsoaOrduak = $orduak;
                    } else if ( $egutegiaOrduakTotal >= $orduak ) {
                        $zenbatEgun = $orduak / $jornada;
                        // Egun osoen kenketa
                        $egunOsoak = (int)$zenbatEgun;
                        // Orduen kenketa
                        $gainontzekoa = $zenbatEgun - (int)$zenbatEgun;

                        $egunOsoaOrduak = $egunOsoak * $jornada;
                        $partziala      = $gainontzekoa * $jornada;
                    }
                }

                $calendar->setHoursSelf( $calendar->getHoursSelf() - $egunOsoaOrduak );
                $calendar->setHoursSelfHalf( $calendar->getHoursSelfHalf() - $partziala );
            }
            if ( $t->getRelated() === 'hours_compensed' ) {
                $calendar->setHoursCompensed(
                    (float)$calendar->getHoursCompensed() - (float)$datuak[ 'event_hours' ]
                );
            }
            if ( $t->getRelated() === 'hours_sindical' ) {
                $calendar->setHoursSindikal(
                    (float)$calendar->getHoursSindikal() - (float)$datuak[ 'event_hours' ]
                );
            }
            $this->em->persist( $calendar );
        }

        $this->em->flush();

        return array(
            'result'=> 1,
            'id' => $event->getId()
        );
    }
}
