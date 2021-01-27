<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Hour.
 *
 * @ORM\Table(name="hour")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HourRepository")
 * @ExclusionPolicy("all")
 */
class Hour
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="hours", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $hours;

    /**
     * @var string
     *
     * @ORM\Column(name="minutes", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $minutes;

    /**
     * @var string
     *
     * @ORM\Column(name="factor", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $factor;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $total;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var Calendar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", inversedBy="hours")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $calendar;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->factor = 1.75;
    }

    public function __toString()
    {
        return $this->getTotal();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Hour
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set hours.
     *
     * @param string $hours
     *
     * @return Hour
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours.
     *
     * @return string
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set minutes.
     *
     * @param string $minutes
     *
     * @return Hour
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * Get minutes.
     *
     * @return string
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set factor.
     *
     * @param string $factor
     *
     * @return Hour
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;

        return $this;
    }

    /**
     * Get factor.
     *
     * @return string
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * Set total.
     *
     * @param string $total
     *
     * @return Hour
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set calendar.
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return Hour
     */
    public function setCalendar(\AppBundle\Entity\Calendar $calendar = null)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar.
     *
     * @return \AppBundle\Entity\Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}
