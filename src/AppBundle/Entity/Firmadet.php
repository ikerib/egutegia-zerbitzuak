<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Firmadet
 *
 * @ORM\Table(name="firmadet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FirmadetRepository")
 * @ExclusionPolicy("all")
 */
class Firmadet
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
     * @ORM\Column(name="noiz", type="datetime", nullable=true)
     * @Expose()
     */
    private $noiz;

    /**
     * @var bool
     *
     * @ORM\Column(name="firmatua", type="boolean", nullable=true)
     * @Expose()
     */
    private $firmatua;

    /**
     * @var bool
     *
     * @ORM\Column(name="postit", type="boolean", nullable=true)
     * @Expose()
     */
    private $postit;

    /**
     * @var bool
     *
     * @ORM\Column(name="autofirma", type="boolean", nullable=true)
     * @Expose()
     */
    private $autofirma;

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
     * @var \AppBundle\Entity\Firma
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Firma", inversedBy="firmadet")
     * @ORM\JoinColumn(name="firma_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $firma;

    /**
     * @var \AppBundle\Entity\Sinatzaileakdet
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sinatzaileakdet", inversedBy="firmadet")
     * @ORM\JoinColumn(name="sinatzaileakdet_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $sinatzaileakdet;


    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="firmadet")
     * @ORM\JoinColumn(name="firmatzaile_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $firmatzailea;


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
     * Set noiz
     *
     * @param \DateTime $noiz
     *
     * @return Firmadet
     */
    public function setNoiz($noiz)
    {
        $this->noiz = $noiz;

        return $this;
    }

    /**
     * Get noiz
     *
     * @return \DateTime
     */
    public function getNoiz()
    {
        return $this->noiz;
    }

    /**
     * Set firmatua
     *
     * @param boolean $firmatua
     *
     * @return Firmadet
     */
    public function setFirmatua($firmatua)
    {
        $this->firmatua = $firmatua;

        return $this;
    }

    /**
     * Get firmatua
     *
     * @return boolean
     */
    public function getFirmatua()
    {
        return $this->firmatua;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Firmadet
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
     * @return Firmadet
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
     * @return Firmadet
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
     * Set firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Firmadet
     */
    public function setFirma(\AppBundle\Entity\Firma $firma = null)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return \AppBundle\Entity\Firma
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set sinatzaileakdet
     *
     * @param \AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet
     *
     * @return Firmadet
     */
    public function setSinatzaileakdet(\AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet = null)
    {
        $this->sinatzaileakdet = $sinatzaileakdet;

        return $this;
    }

    /**
     * Get sinatzaileakdet
     *
     * @return \AppBundle\Entity\Sinatzaileakdet
     */
    public function getSinatzaileakdet()
    {
        return $this->sinatzaileakdet;
    }

    /**
     * Set firmatzailea
     *
     * @param \AppBundle\Entity\User $firmatzailea
     *
     * @return Firmadet
     */
    public function setFirmatzailea(\AppBundle\Entity\User $firmatzailea = null)
    {
        $this->firmatzailea = $firmatzailea;

        return $this;
    }

    /**
     * Get firmatzailea
     *
     * @return \AppBundle\Entity\User
     */
    public function getFirmatzailea()
    {
        return $this->firmatzailea;
    }

    /**
     * Set postit.
     *
     * @param bool|null $postit
     *
     * @return Firmadet
     */
    public function setPostit($postit = null)
    {
        $this->postit = $postit;

        return $this;
    }

    /**
     * Get postit.
     *
     * @return bool|null
     */
    public function getPostit()
    {
        return $this->postit;
    }

    /**
     * Set autofirma.
     *
     * @param bool|null $autofirma
     *
     * @return Firmadet
     */
    public function setAutofirma($autofirma = null)
    {
        $this->autofirma = $autofirma;

        return $this;
    }

    /**
     * Get autofirma.
     *
     * @return bool|null
     */
    public function getAutofirma()
    {
        return $this->autofirma;
    }
}
