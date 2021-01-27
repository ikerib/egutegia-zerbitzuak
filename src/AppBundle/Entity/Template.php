<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Template.
 *
 * @ORM\Table(name="template")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemplateRepository")
 * @ExclusionPolicy("all")
 */
class Template
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose()
     */
    private $name;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours_year", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours_year = 0;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours_free", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours_free = 0;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours_self", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours_self = 0;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours_compensed", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours_compensed = 0;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours_day", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours_day = 0;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=105, unique=true)
     * @Expose()
     */
    private $slug;

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
     * @var template_events[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TemplateEvent", mappedBy="template",cascade={"remove"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $template_events;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->template_events = new ArrayCollection();
    }

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
     * @return Template
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
     * Set hoursYear.
     *
     * @param string $hoursYear
     *
     * @return Template
     */
    public function setHoursYear($hoursYear)
    {
        $this->hours_year = $hoursYear;

        return $this;
    }

    /**
     * Get hoursYear.
     *
     * @return string
     */
    public function getHoursYear()
    {
        return $this->hours_year;
    }

    /**
     * Set hoursFree.
     *
     * @param string $hoursFree
     *
     * @return Template
     */
    public function setHoursFree($hoursFree)
    {
        $this->hours_free = $hoursFree;

        return $this;
    }

    /**
     * Get hoursFree.
     *
     * @return string
     */
    public function getHoursFree()
    {
        return $this->hours_free;
    }

    /**
     * Set hoursSelf.
     *
     * @param string $hoursSelf
     *
     * @return Template
     */
    public function setHoursSelf($hoursSelf)
    {
        $this->hours_self = $hoursSelf;

        return $this;
    }

    /**
     * Get hoursSelf.
     *
     * @return string
     */
    public function getHoursSelf()
    {
        return $this->hours_self;
    }

    /**
     * Set hoursCompensed.
     *
     * @param string $hoursCompensed
     *
     * @return Template
     */
    public function setHoursCompensed($hoursCompensed)
    {
        $this->hours_compensed = $hoursCompensed;

        return $this;
    }

    /**
     * Get hoursCompensed.
     *
     * @return string
     */
    public function getHoursCompensed()
    {
        return $this->hours_compensed;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Template
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Template
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
     * @return Template
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
     * Add templateEvent.
     *
     * @param \AppBundle\Entity\TemplateEvent $templateEvent
     *
     * @return Template
     */
    public function addTemplateEvent(\AppBundle\Entity\TemplateEvent $templateEvent)
    {
        $this->template_events[] = $templateEvent;

        return $this;
    }

    /**
     * Remove templateEvent.
     *
     * @param \AppBundle\Entity\TemplateEvent $templateEvent
     */
    public function removeTemplateEvent(\AppBundle\Entity\TemplateEvent $templateEvent)
    {
        $this->template_events->removeElement($templateEvent);
    }

    /**
     * Get templateEvents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemplateEvents()
    {
        return $this->template_events;
    }

    /**
     * Set hoursDay.
     *
     * @param string $hoursDay
     *
     * @return Template
     */
    public function setHoursDay($hoursDay)
    {
        $this->hours_day = $hoursDay;

        return $this;
    }

    /**
     * Get hoursDay.
     *
     * @return string
     */
    public function getHoursDay()
    {
        return $this->hours_day;
    }
}
