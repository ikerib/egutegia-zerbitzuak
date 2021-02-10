<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Azpisaila
 *
 * @ORM\Table(name="azpisaila")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AzpisailaRepository")
 */
class Azpisaila
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
     * @var Saila
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Saila", inversedBy="azpisailak")
     * @ORM\JoinColumn(name="saila_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $saila;

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
     * @return Azpisaila
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
     * Set saila.
     *
     * @param \AppBundle\Entity\Saila|null $saila
     *
     * @return Azpisaila
     */
    public function setSaila(\AppBundle\Entity\Saila $saila = null)
    {
        $this->saila = $saila;

        return $this;
    }

    /**
     * Get saila.
     *
     * @return \AppBundle\Entity\Saila|null
     */
    public function getSaila()
    {
        return $this->saila;
    }
}
