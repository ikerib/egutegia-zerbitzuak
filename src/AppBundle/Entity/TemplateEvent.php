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
//use JMS\Serializer\Annotation\ExclusionPolicy;
//use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * TemplateEvent.
 *
 * @ORM\Table(name="template_event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemplateEventRepository")
 */
class TemplateEvent
{
    /**
     * @var \AppBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", inversedBy="template_events")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $type;
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
     * @var \AppBundle\Entity\Template
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Template", inversedBy="template_events")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $template;

    public function __toString()
    {
        return (string) $this->getSlug();
    }

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
     * @return TemplateEvent
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
     * @return TemplateEvent
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
     * @return TemplateEvent
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
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return TemplateEvent
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
     * @return TemplateEvent
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
     * Set template.
     *
     * @param \AppBundle\Entity\Template $template
     *
     * @return TemplateEvent
     */
    public function setTemplate(\AppBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template.
     *
     * @return \AppBundle\Entity\Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set type.
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return TemplateEvent
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
