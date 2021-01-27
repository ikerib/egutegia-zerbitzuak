<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Event.
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @ExclusionPolicy("all")
 */
class Event
{
    /**
     * @var int
     * @Expose
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="egunorduak", type="string", length=255, nullable=true)
     */
    private $egunorduak;

    /**
     * @var \DateTime
     * @Expose
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * @var \DateTime
     * @Expose
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $end_date;

    /**
     * @var decimal
     * @Expose
     *
     * @ORM\Column(name="hours", type="decimal", precision=10, scale=2)
     */
    private $hours = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="nondik", type="string", length=255, nullable=true)
     */
    private $nondik;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hoursSelfBefore", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $hoursSelfBefore = 0;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hoursSelfHalfBefore", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $hoursSelfHalfBefore = 0;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var \AppBundle\Entity\Calendar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", inversedBy="events")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $calendar;

    /**
     * @var \AppBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", inversedBy="events")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $type;

    public function __toString()
    {
        return (string) $this->getSlug().'';
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
     * Set name.
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate.
     *
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set hours.
     *
     * @param string $hours
     *
     * @return Event
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
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Event
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Event
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set calendar.
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return Event
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

    /**
     * Set type.
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Event
     */
    public function setType(\AppBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return \AppBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set egunorduak
     *
     * @param string $egunorduak
     *
     * @return Event
     */
    public function setEgunorduak($egunorduak)
    {
        $this->egunorduak = $egunorduak;

        return $this;
    }

    /**
     * Get egunorduak
     *
     * @return string
     */
    public function getEgunorduak()
    {
        return $this->egunorduak;
    }

    /**
     * Set nondik.
     *
     * @param string|null $nondik
     *
     * @return Event
     */
    public function setNondik($nondik = null)
    {
        $this->nondik = $nondik;

        return $this;
    }

    /**
     * Get nondik.
     *
     * @return string|null
     */
    public function getNondik()
    {
        return $this->nondik;
    }

    /**
     * Set hoursSelfBefore.
     *
     * @param string|null $hoursSelfBefore
     *
     * @return Event
     */
    public function setHoursSelfBefore($hoursSelfBefore = null)
    {
        $this->hoursSelfBefore = $hoursSelfBefore;

        return $this;
    }

    /**
     * Get hoursSelfBefore.
     *
     * @return string|null
     */
    public function getHoursSelfBefore()
    {
        return $this->hoursSelfBefore;
    }

    /**
     * Set hoursSelfHalfBefore.
     *
     * @param string|null $hoursSelfHalfBefore
     *
     * @return Event
     */
    public function setHoursSelfHalfBefore($hoursSelfHalfBefore = null)
    {
        $this->hoursSelfHalfBefore = $hoursSelfHalfBefore;

        return $this;
    }

    /**
     * Get hoursSelfHalfBefore.
     *
     * @return string|null
     */
    public function getHoursSelfHalfBefore()
    {
        return $this->hoursSelfHalfBefore;
    }
}
