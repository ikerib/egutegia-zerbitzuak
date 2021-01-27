<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Gutxienekoakdet
 *
 * @ORM\Table(name="gutxienekoakdet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GutxienekoakdetRepository")
 * @ExclusionPolicy("all")
 */
class Gutxienekoakdet
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
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var \AppBundle\Entity\Gutxienekoak
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Gutxienekoak", inversedBy="gutxienekoakdet")
     * @ORM\JoinColumn(name="gutxienekoak_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $gutxienekoak;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="calendars")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    public function __toString()
    {
        return (string) $this->getId().'';
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Gutxienekoakdet
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
     * @return Gutxienekoakdet
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
     * @return Gutxienekoakdet
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
     * Set gutxienekoak
     *
     * @param \AppBundle\Entity\Gutxienekoak $gutxienekoak
     *
     * @return Gutxienekoakdet
     */
    public function setGutxienekoak(\AppBundle\Entity\Gutxienekoak $gutxienekoak = null)
    {
        $this->gutxienekoak = $gutxienekoak;

        return $this;
    }

    /**
     * Get gutxienekoak
     *
     * @return \AppBundle\Entity\Gutxienekoak
     */
    public function getGutxienekoak()
    {
        return $this->gutxienekoak;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Gutxienekoakdet
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
