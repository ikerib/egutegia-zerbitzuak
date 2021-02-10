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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Saila", inversedBy="azpisailak")
     * @ORM\JoinColumn(name="saila_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $saila;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="azpisaila",cascade={"persist"})
     */
    private $user;

    public function __toString(): string
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

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Azpisaila
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Azpisaila
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        return $this->user->removeElement($user);
    }
}
