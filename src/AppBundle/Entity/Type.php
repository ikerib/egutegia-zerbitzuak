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
 * Type.
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRepository")
 * @ExclusionPolicy("all")
 */
class Type
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Expose()
     */
    private $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=105, unique=true)
     * @Expose()
     */
    private $slug;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     * @Expose()
     */
    private $color = '#e01b1b';

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

    /**
     * @var int
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /**
     * @var bool
     * @ORM\Column(name="erakutsi", type="boolean", nullable=true)
     */
    private $erakutsi;

    /**
     * @var bool
     * @ORM\Column(name="erakutsi_eskaera", type="boolean", nullable=true)
     */
    private $erakutsi_eskaera;

    /**
     * @var string
     * @ORM\Column(name="related", type="string", nullable=true)
     */
    private $related;

    /**
     * @var bool
     * @ORM\Column(name="lizentziamotabehar", type="boolean", nullable=true)
     */
    private $lizentziamotabehar;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var events[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", mappedBy="type",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     * @Expose()
     */
    private $events;

    /**
     * @var template_events[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TemplateEvent", mappedBy="type",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $template_events;

    /**
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Eskaera", mappedBy="type",cascade={"persist"})
     */
    protected $eskaera;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->template_events = new ArrayCollection();
        $this->color = '#e01b1b';
        $this->erakutsi = true;
    }

    public function __toString()
    {
        return $this->getSlug();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Type
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set hours
     *
     * @param string $hours
     *
     * @return Type
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return string
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Type
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Type
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Type
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Type
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set erakutsi
     *
     * @param boolean $erakutsi
     *
     * @return Type
     */
    public function setErakutsi($erakutsi)
    {
        $this->erakutsi = $erakutsi;

        return $this;
    }

    /**
     * Get erakutsi
     *
     * @return boolean
     */
    public function getErakutsi()
    {
        return $this->erakutsi;
    }

    /**
     * Set erakutsiEskaera
     *
     * @param boolean $erakutsiEskaera
     *
     * @return Type
     */
    public function setErakutsiEskaera($erakutsiEskaera)
    {
        $this->erakutsi_eskaera = $erakutsiEskaera;

        return $this;
    }

    /**
     * Get erakutsiEskaera
     *
     * @return boolean
     */
    public function getErakutsiEskaera()
    {
        return $this->erakutsi_eskaera;
    }

    /**
     * Set related
     *
     * @param string $related
     *
     * @return Type
     */
    public function setRelated($related)
    {
        $this->related = $related;

        return $this;
    }

    /**
     * Get related
     *
     * @return string
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Type
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add templateEvent
     *
     * @param \AppBundle\Entity\TemplateEvent $templateEvent
     *
     * @return Type
     */
    public function addTemplateEvent(\AppBundle\Entity\TemplateEvent $templateEvent)
    {
        $this->template_events[] = $templateEvent;

        return $this;
    }

    /**
     * Remove templateEvent
     *
     * @param \AppBundle\Entity\TemplateEvent $templateEvent
     */
    public function removeTemplateEvent(\AppBundle\Entity\TemplateEvent $templateEvent)
    {
        $this->template_events->removeElement($templateEvent);
    }

    /**
     * Get templateEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemplateEvents()
    {
        return $this->template_events;
    }

    /**
     * Add eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return Type
     */
    public function addEskaera(\AppBundle\Entity\Eskaera $eskaera)
    {
        $this->eskaera[] = $eskaera;

        return $this;
    }

    /**
     * Remove eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     */
    public function removeEskaera(\AppBundle\Entity\Eskaera $eskaera)
    {
        $this->eskaera->removeElement($eskaera);
    }

    /**
     * Get eskaera
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Type
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set lizentziamotabehar.
     *
     * @param bool|null $lizentziamotabehar
     *
     * @return Type
     */
    public function setLizentziamotabehar($lizentziamotabehar = null)
    {
        $this->lizentziamotabehar = $lizentziamotabehar;

        return $this;
    }

    /**
     * Get lizentziamotabehar.
     *
     * @return bool|null
     */
    public function getLizentziamotabehar()
    {
        return $this->lizentziamotabehar;
    }
}
