<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"main"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"main"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Serializer\Groups({"main"})
     */
    private $description;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="readed", type="boolean", nullable=true)
     * @Serializer\Groups({"main"})
     */
    private $readed;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="readedAt", type="datetime", nullable=true)
     * @Serializer\Groups({"main"})
     */
    private $readedAt;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"main"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    public function __construct()
    {
        $this->readed = false;
        $this->readedAt = null;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /*****************************************************************************************************************/
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
     * @return Message
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
     * Set description.
     *
     * @param string $description
     *
     * @return Message
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set readed.
     *
     * @param bool|null $readed
     *
     * @return Message
     */
    public function setReaded($readed = null)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed.
     *
     * @return bool|null
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set readedAt.
     *
     * @param \DateTime|null $readedAt
     *
     * @return Message
     */
    public function setReadedAt($readedAt = null)
    {
        $this->readedAt = $readedAt;

        return $this;
    }

    /**
     * Get readedAt.
     *
     * @return \DateTime|null
     */
    public function getReadedAt()
    {
        return $this->readedAt;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Message
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
     * @return Message
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
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Message
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
}
