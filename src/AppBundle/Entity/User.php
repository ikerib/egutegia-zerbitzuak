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
use FOS\UserBundle\Model\User as BaseUser;
use FR3D\LdapBundle\Model\LdapUserInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser implements LdapUserInterface
{
    /**
     * @var int
     * @Expose
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $dn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $displayname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $nan;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true, options={"default": false})
     * @Expose
     */
    protected $sailburuada;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $ldapsaila;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $hizkuntza;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $lanpostua;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $notes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $rola;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $members = [];

    ///**
    // * @var members[]
    // * @ORM\Column(type="string")
    // */
    //protected $members;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var calendars[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Calendar", mappedBy="user",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $calendars;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="user",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $messages;

    /**
     * @var \AppBundle\Entity\Notification
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="user")
     */
    protected $notifications;

    /**
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Eskaera", mappedBy="user")
     */
    protected $eskaera;

    /**
     * @var \AppBundle\Entity\Firmadet
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Firmadet", mappedBy="firmatzailea")
     */
    protected $firmadet;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Saila", inversedBy="user")
     * @ORM\JoinColumn(name="saila_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $saila;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Azpisaila", inversedBy="user")
     * @ORM\JoinColumn(name="azpisaila_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $azpisaila;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->members = [];
        $this->calendars = new ArrayCollection();
//        $this->azpisaila = new ArrayCollection();
//        $this->saila = new ArrayCollection();
        if (empty($this->roles)) {
            $this->roles[] = 'ROLE_USER';
        }
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    //public function addMembers($member)  {
    //    if (!in_array($member, $this->members, true)) {
    //        $this->members[] = $member;
    //    }
    //
    //    return $this;
    //}
    //
    //public function getMembers()
    //{
    //    return array_unique($this->members);
    //}
    //
    //public function hasMembers($member)
    //{
    //    return in_array(strtoupper($member), $this->getMembers(), true);
    //}

    public function getMembers()
    {
        return $this->members;
    }

    public function setMembers(array $members)
    {
        $this->members = $members;

        // allows for chaining
        return $this;
    }

    /**
     * Set Ldap Distinguished Name.
     *
     * @param string $dn Distinguished Name
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
    }

    /**
     * Get Ldap Distinguished Name.
     *
     * @return null|string Distinguished Name
     */
    public function getDn()
    {
        return $this->dn;
    }



    /**
     * Set department.
     *
     * @param string|null $department
     *
     * @return User
     */
    public function setDepartment($department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return string|null
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set displayname.
     *
     * @param string|null $displayname
     *
     * @return User
     */
    public function setDisplayname($displayname = null)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname.
     *
     * @return string|null
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Set nan.
     *
     * @param string|null $nan
     *
     * @return User
     */
    public function setNan($nan = null)
    {
        $this->nan = $nan;

        return $this;
    }

    /**
     * Get nan.
     *
     * @return string|null
     */
    public function getNan()
    {
        return $this->nan;
    }

    /**
     * Set sailburuada.
     *
     * @param bool|null $sailburuada
     *
     * @return User
     */
    public function setSailburuada($sailburuada = null)
    {
        $this->sailburuada = $sailburuada;

        return $this;
    }

    /**
     * Get sailburuada.
     *
     * @return bool|null
     */
    public function getSailburuada()
    {
        return $this->sailburuada;
    }

    /**
     * Set ldapsaila.
     *
     * @param string|null $ldapsaila
     *
     * @return User
     */
    public function setLdapsaila($ldapsaila = null)
    {
        $this->ldapsaila = $ldapsaila;

        return $this;
    }

    /**
     * Get ldapsaila.
     *
     * @return string|null
     */
    public function getLdapsaila()
    {
        return $this->ldapsaila;
    }

    /**
     * Set hizkuntza.
     *
     * @param string|null $hizkuntza
     *
     * @return User
     */
    public function setHizkuntza($hizkuntza = null)
    {
        $this->hizkuntza = $hizkuntza;

        return $this;
    }

    /**
     * Get hizkuntza.
     *
     * @return string|null
     */
    public function getHizkuntza()
    {
        return $this->hizkuntza;
    }

    /**
     * Set lanpostua.
     *
     * @param string|null $lanpostua
     *
     * @return User
     */
    public function setLanpostua($lanpostua = null)
    {
        $this->lanpostua = $lanpostua;

        return $this;
    }

    /**
     * Get lanpostua.
     *
     * @return string|null
     */
    public function getLanpostua()
    {
        return $this->lanpostua;
    }

    /**
     * Set notes.
     *
     * @param string|null $notes
     *
     * @return User
     */
    public function setNotes($notes = null)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes.
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add calendar.
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return User
     */
    public function addCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        $this->calendars[] = $calendar;

        return $this;
    }

    /**
     * Remove calendar.
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        return $this->calendars->removeElement($calendar);
    }

    /**
     * Get calendars.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendars()
    {
        return $this->calendars;
    }

    /**
     * Add message.
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return User
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message.
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        return $this->messages->removeElement($message);
    }

    /**
     * Get messages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add notification.
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return User
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification.
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        return $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Add eskaera.
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return User
     */
    public function addEskaera(\AppBundle\Entity\Eskaera $eskaera)
    {
        $this->eskaera[] = $eskaera;

        return $this;
    }

    /**
     * Remove eskaera.
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEskaera(\AppBundle\Entity\Eskaera $eskaera)
    {
        return $this->eskaera->removeElement($eskaera);
    }

    /**
     * Get eskaera.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }

    /**
     * Add firmadet.
     *
     * @param \AppBundle\Entity\Firmadet $firmadet
     *
     * @return User
     */
    public function addFirmadet(\AppBundle\Entity\Firmadet $firmadet)
    {
        $this->firmadet[] = $firmadet;

        return $this;
    }

    /**
     * Remove firmadet.
     *
     * @param \AppBundle\Entity\Firmadet $firmadet
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFirmadet(\AppBundle\Entity\Firmadet $firmadet)
    {
        return $this->firmadet->removeElement($firmadet);
    }

    /**
     * Get firmadet.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirmadet()
    {
        return $this->firmadet;
    }

    /**
     * Set saila.
     *
     * @param \AppBundle\Entity\Saila|null $saila
     *
     * @return User
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
     * Set azpisaila.
     *
     * @param \AppBundle\Entity\Azpisaila|null $azpisaila
     *
     * @return User
     */
    public function setAzpisaila(\AppBundle\Entity\Azpisaila $azpisaila = null)
    {
        $this->azpisaila = $azpisaila;

        return $this;
    }

    /**
     * Get azpisaila.
     *
     * @return \AppBundle\Entity\Azpisaila|null
     */
    public function getAzpisaila()
    {
        return $this->azpisaila;
    }

    /**
     * Set rola.
     *
     * @param string|null $rola
     *
     * @return User
     */
    public function setRola($rola = null)
    {
        $this->rola = $rola;

        return $this;
    }

    /**
     * Get rola.
     *
     * @return string|null
     */
    public function getRola()
    {
        return $this->rola;
    }
}
