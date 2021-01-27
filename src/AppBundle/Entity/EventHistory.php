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
use JMS\Serializer\Annotation\Expose;

/**
 * EventHistory.
 *
 * @ORM\Table(name="event_history")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventHistoryRepository")
 */
class EventHistory
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $end_date;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours", type="decimal", precision=10, scale=2)
     */
    private $hours = 0;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $calendar;

    /**
     * @var \AppBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $type;

    public function __toString()
    {
        return $this->getSlug();
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
     * @return EventHistory
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
     * @return EventHistory
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
     * @return EventHistory
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
     * @return EventHistory
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
     * @return EventHistory
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
     * @return EventHistory
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
     * @return EventHistory
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
     * @return EventHistory
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
}
