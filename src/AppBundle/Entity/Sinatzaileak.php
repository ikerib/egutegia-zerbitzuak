<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Sinatzaileak
 *
 * @ORM\Table(name="sinatzaileak")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SinatzaileakRepository")
 * @ExclusionPolicy("all")
 */
class Sinatzaileak
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
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
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
     * @var \AppBundle\Entity\Sinatzaileakdet
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sinatzaileakdet", mappedBy="sinatzaileak")
     */
    protected $sinatzaileakdet;

    /**
     * @var \AppBundle\Entity\Firma
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Firma", mappedBy="sinatzaileak")
     */
    protected $firma;

    /**
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Eskaera", mappedBy="sinatzaileak")
     */
    protected $eskaera;

    public function __toString()
    {
        return (string) $this->getName().'';
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sinatzaileakdet = new \Doctrine\Common\Collections\ArrayCollection();
        $this->firma = new \Doctrine\Common\Collections\ArrayCollection();
        $this->eskaera = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Sinatzaileak
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Sinatzaileak
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
     * @return Sinatzaileak
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
     * @return Sinatzaileak
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
     * Add sinatzaileakdet
     *
     * @param \AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet
     *
     * @return Sinatzaileak
     */
    public function addSinatzaileakdet(\AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet)
    {
        $this->sinatzaileakdet[] = $sinatzaileakdet;

        return $this;
    }

    /**
     * Remove sinatzaileakdet
     *
     * @param \AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet
     */
    public function removeSinatzaileakdet(\AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet)
    {
        $this->sinatzaileakdet->removeElement($sinatzaileakdet);
    }

    /**
     * Get sinatzaileakdet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSinatzaileakdet()
    {
        return $this->sinatzaileakdet;
    }

    /**
     * Add firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Sinatzaileak
     */
    public function addFirma(\AppBundle\Entity\Firma $firma)
    {
        $this->firma[] = $firma;

        return $this;
    }

    /**
     * Remove firma
     *
     * @param \AppBundle\Entity\Firma $firma
     */
    public function removeFirma(\AppBundle\Entity\Firma $firma)
    {
        $this->firma->removeElement($firma);
    }

    /**
     * Get firma
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Add eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return Sinatzaileak
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
}
