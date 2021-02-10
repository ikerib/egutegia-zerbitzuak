<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Saila
 *
 * @ORM\Table(name="saila")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SailaRepository")
 */
class Saila
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Azpisaila", mappedBy="saila",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $azpisailak;

    public function __construct()
    {
        $this->azpisailak = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }
    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
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
     * @return Saila
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
     * Add azpisailak.
     *
     * @param \AppBundle\Entity\Azpisaila $azpisailak
     *
     * @return Saila
     */
    public function addAzpisailak(\AppBundle\Entity\Azpisaila $azpisailak)
    {
        $this->azpisailak[] = $azpisailak;

        return $this;
    }

    /**
     * Remove azpisailak.
     *
     * @param \AppBundle\Entity\Azpisaila $azpisailak
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAzpisailak(\AppBundle\Entity\Azpisaila $azpisailak)
    {
        return $this->azpisailak->removeElement($azpisailak);
    }

    /**
     * Get azpisailak.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAzpisailak()
    {
        return $this->azpisailak;
    }
}
