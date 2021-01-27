<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Firma
 *
 * @ORM\Table(name="firma")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FirmaRepository")
 * @ExclusionPolicy("all")
 */
class Firma
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
     * @Expose()
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="completed", type="boolean")
     * @Expose()
     */
    private $completed;

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
     * @Expose()
     */
    private $orden;

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
     * @var \AppBundle\Entity\Firmadet
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Firmadet", mappedBy="firma")
     */
    protected $firmadet;

    /**
     * @var \AppBundle\Entity\Notification
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="firma")
     */
    protected $notifications;

    /**
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Eskaera", inversedBy="firma")
     * @ORM\JoinColumn(name="eskaera_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $eskaera;

    /**
     * @var \AppBundle\Entity\Sinatzaileak
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sinatzaileak", inversedBy="firma")
     * @ORM\JoinColumn(name="sinatzaile_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $sinatzaileak;


    public function __toString()
    {
        return (string) $this->getName().'';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->firmadet = new ArrayCollection();
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
     * @return Firma
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
     * Set completed
     *
     * @param boolean $completed
     *
     * @return Firma
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Firma
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Firma
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
     * @return Firma
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
     * Add firmadet
     *
     * @param \AppBundle\Entity\Firmadet $firmadet
     *
     * @return Firma
     */
    public function addFirmadet(\AppBundle\Entity\Firmadet $firmadet)
    {
        $this->firmadet[] = $firmadet;

        return $this;
    }

    /**
     * Remove firmadet
     *
     * @param \AppBundle\Entity\Firmadet $firmadet
     */
    public function removeFirmadet(\AppBundle\Entity\Firmadet $firmadet)
    {
        $this->firmadet->removeElement($firmadet);
    }

    /**
     * Get firmadet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirmadet()
    {
        return $this->firmadet;
    }

    /**
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Firma
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \AppBundle\Entity\Notification $notification
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return Firma
     */
    public function setEskaera(\AppBundle\Entity\Eskaera $eskaera = null)
    {
        $this->eskaera = $eskaera;

        return $this;
    }

    /**
     * Get eskaera
     *
     * @return \AppBundle\Entity\Eskaera
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }

    /**
     * Set sinatzaileak
     *
     * @param \AppBundle\Entity\Sinatzaileak $sinatzaileak
     *
     * @return Firma
     */
    public function setSinatzaileak(\AppBundle\Entity\Sinatzaileak $sinatzaileak = null)
    {
        $this->sinatzaileak = $sinatzaileak;

        return $this;
    }

    /**
     * Get sinatzaileak
     *
     * @return \AppBundle\Entity\Sinatzaileak
     */
    public function getSinatzaileak()
    {
        return $this->sinatzaileak;
    }
}
