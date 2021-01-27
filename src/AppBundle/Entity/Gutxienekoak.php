<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Gutxienekoak
 *
 * @ORM\Table(name="gutxienekoak")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GutxienekoakRepository")
 * @ExclusionPolicy("all")
 */
class Gutxienekoak
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
     * @var string
     *
     * @ORM\Column(name="portzentaia", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $portzentaia;

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
     * @var \AppBundle\Entity\Gutxienekoakdet
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Gutxienekoakdet", mappedBy="gutxienekoak")
     */
    protected $gutxienekoakdet;

    public function __toString()
    {
        return (string) $this->getName().'';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gutxienekoakdet = new ArrayCollection();
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
     * @return Gutxienekoak
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
     * Set portzentaia
     *
     * @param string $portzentaia
     *
     * @return Gutxienekoak
     */
    public function setPortzentaia($portzentaia)
    {
        $this->portzentaia = $portzentaia;

        return $this;
    }

    /**
     * Get portzentaia
     *
     * @return string
     */
    public function getPortzentaia()
    {
        return $this->portzentaia;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Gutxienekoak
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
     * @return Gutxienekoak
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
     * Add gutxienekoakdet
     *
     * @param \AppBundle\Entity\Gutxienekoakdet $gutxienekoakdet
     *
     * @return Gutxienekoak
     */
    public function addGutxienekoakdet(\AppBundle\Entity\Gutxienekoakdet $gutxienekoakdet)
    {
        $this->gutxienekoakdet[] = $gutxienekoakdet;

        return $this;
    }

    /**
     * Remove gutxienekoakdet
     *
     * @param \AppBundle\Entity\Gutxienekoakdet $gutxienekoakdet
     */
    public function removeGutxienekoakdet(\AppBundle\Entity\Gutxienekoakdet $gutxienekoakdet)
    {
        $this->gutxienekoakdet->removeElement($gutxienekoakdet);
    }

    /**
     * Get gutxienekoakdet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGutxienekoakdet()
    {
        return $this->gutxienekoakdet;
    }
}
