<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Kuadrantea
 *
 * @ORM\Table(name="kuadrantea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KuadranteaRepository")
 */
class Kuadrantea
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
     * @var integer
     *
     * @ORM\Column(name="urtea", type="integer", nullable=true)
     */
    private $urtea;

    /**
     * @var string
     *
     * @ORM\Column(name="hilabetea", type="string", length=20, nullable=true)
     */
    private $hilabetea;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day01", type="string", length=50, nullable=true)
     */
    private $day01;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day02", type="string", length=50, nullable=true)
     */
    private $day02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day03", type="string", length=50, nullable=true)
     */
    private $day03;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day04", type="string", length=50, nullable=true)
     */
    private $day04;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day05", type="string", length=50, nullable=true)
     */
    private $day05;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day06", type="string", length=50, nullable=true)
     */
    private $day06;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day07", type="string", length=50, nullable=true)
     */
    private $day07;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day08", type="string", length=50, nullable=true)
     */
    private $day08;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day09", type="string", length=50, nullable=true)
     */
    private $day09;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day10", type="string", length=50, nullable=true)
     */
    private $day10;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day11", type="string", length=50, nullable=true)
     */
    private $day11;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day12", type="string", length=50, nullable=true)
     */
    private $day12;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day13", type="string", length=50, nullable=true)
     */
    private $day13;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day14", type="string", length=50, nullable=true)
     */
    private $day14;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day15", type="string", length=50, nullable=true)
     */
    private $day15;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day16", type="string", length=50, nullable=true)
     */
    private $day16;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day17", type="string", length=50, nullable=true)
     */
    private $day17;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day18", type="string", length=50, nullable=true)
     */
    private $day18;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day19", type="string", length=50, nullable=true)
     */
    private $day19;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day20", type="string", length=50, nullable=true)
     */
    private $day20;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day21", type="string", length=50, nullable=true)
     */
    private $day21;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day22", type="string", length=50, nullable=true)
     */
    private $day22;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day23", type="string", length=50, nullable=true)
     */
    private $day23;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day24", type="string", length=50, nullable=true)
     */
    private $day24;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day25", type="string", length=50, nullable=true)
     */
    private $day25;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day26", type="string", length=50, nullable=true)
     */
    private $day26;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day27", type="string", length=50, nullable=true)
     */
    private $day27;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day28", type="string", length=50, nullable=true)
     */
    private $day28;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day29", type="string", length=50, nullable=true)
     */
    private $day29;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day30", type="string", length=50, nullable=true)
     */
    private $day30;

    /**
     * @var string|null
     *
     * @ORM\Column(name="day31", type="string", length=50, nullable=true)
     */
    private $day31;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/


    public function __toString()
    {
        return $this->hilabetea;
    }

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="kuadranteak")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

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
     * Set hilabetea.
     *
     * @param string $hilabetea
     *
     * @return Kuadrantea
     */
    public function setHilabetea($hilabetea)
    {
        $this->hilabetea = $hilabetea;

        return $this;
    }

    /**
     * Get hilabetea.
     *
     * @return string
     */
    public function getHilabetea()
    {
        return $this->hilabetea;
    }

    /**
     * Set day01.
     *
     * @param string|null $day01
     *
     * @return Kuadrantea
     */
    public function setDay01($day01 = null)
    {
        $this->day01 = $day01;

        return $this;
    }

    /**
     * Get day01.
     *
     * @return string|null
     */
    public function getDay01()
    {
        return $this->day01;
    }

    /**
     * Set day02.
     *
     * @param string|null $day02
     *
     * @return Kuadrantea
     */
    public function setDay02($day02 = null)
    {
        $this->day02 = $day02;

        return $this;
    }

    /**
     * Get day02.
     *
     * @return string|null
     */
    public function getDay02()
    {
        return $this->day02;
    }

    /**
     * Set day03.
     *
     * @param string|null $day03
     *
     * @return Kuadrantea
     */
    public function setDay03($day03 = null)
    {
        $this->day03 = $day03;

        return $this;
    }

    /**
     * Get day03.
     *
     * @return string|null
     */
    public function getDay03()
    {
        return $this->day03;
    }

    /**
     * Set day04.
     *
     * @param string|null $day04
     *
     * @return Kuadrantea
     */
    public function setDay04($day04 = null)
    {
        $this->day04 = $day04;

        return $this;
    }

    /**
     * Get day04.
     *
     * @return string|null
     */
    public function getDay04()
    {
        return $this->day04;
    }

    /**
     * Set day05.
     *
     * @param string|null $day05
     *
     * @return Kuadrantea
     */
    public function setDay05($day05 = null)
    {
        $this->day05 = $day05;

        return $this;
    }

    /**
     * Get day05.
     *
     * @return string|null
     */
    public function getDay05()
    {
        return $this->day05;
    }

    /**
     * Set day06.
     *
     * @param string|null $day06
     *
     * @return Kuadrantea
     */
    public function setDay06($day06 = null)
    {
        $this->day06 = $day06;

        return $this;
    }

    /**
     * Get day06.
     *
     * @return string|null
     */
    public function getDay06()
    {
        return $this->day06;
    }

    /**
     * Set day07.
     *
     * @param string|null $day07
     *
     * @return Kuadrantea
     */
    public function setDay07($day07 = null)
    {
        $this->day07 = $day07;

        return $this;
    }

    /**
     * Get day07.
     *
     * @return string|null
     */
    public function getDay07()
    {
        return $this->day07;
    }

    /**
     * Set day08.
     *
     * @param string|null $day08
     *
     * @return Kuadrantea
     */
    public function setDay08($day08 = null)
    {
        $this->day08 = $day08;

        return $this;
    }

    /**
     * Get day08.
     *
     * @return string|null
     */
    public function getDay08()
    {
        return $this->day08;
    }

    /**
     * Set day09.
     *
     * @param string|null $day09
     *
     * @return Kuadrantea
     */
    public function setDay09($day09 = null)
    {
        $this->day09 = $day09;

        return $this;
    }

    /**
     * Get day09.
     *
     * @return string|null
     */
    public function getDay09()
    {
        return $this->day09;
    }

    /**
     * Set day10.
     *
     * @param string|null $day10
     *
     * @return Kuadrantea
     */
    public function setDay10($day10 = null)
    {
        $this->day10 = $day10;

        return $this;
    }

    /**
     * Get day10.
     *
     * @return string|null
     */
    public function getDay10()
    {
        return $this->day10;
    }

    /**
     * Set day11.
     *
     * @param string|null $day11
     *
     * @return Kuadrantea
     */
    public function setDay11($day11 = null)
    {
        $this->day11 = $day11;

        return $this;
    }

    /**
     * Get day11.
     *
     * @return string|null
     */
    public function getDay11()
    {
        return $this->day11;
    }

    /**
     * Set day12.
     *
     * @param string|null $day12
     *
     * @return Kuadrantea
     */
    public function setDay12($day12 = null)
    {
        $this->day12 = $day12;

        return $this;
    }

    /**
     * Get day12.
     *
     * @return string|null
     */
    public function getDay12()
    {
        return $this->day12;
    }

    /**
     * Set day13.
     *
     * @param string|null $day13
     *
     * @return Kuadrantea
     */
    public function setDay13($day13 = null)
    {
        $this->day13 = $day13;

        return $this;
    }

    /**
     * Get day13.
     *
     * @return string|null
     */
    public function getDay13()
    {
        return $this->day13;
    }

    /**
     * Set day14.
     *
     * @param string|null $day14
     *
     * @return Kuadrantea
     */
    public function setDay14($day14 = null)
    {
        $this->day14 = $day14;

        return $this;
    }

    /**
     * Get day14.
     *
     * @return string|null
     */
    public function getDay14()
    {
        return $this->day14;
    }

    /**
     * Set day15.
     *
     * @param string|null $day15
     *
     * @return Kuadrantea
     */
    public function setDay15($day15 = null)
    {
        $this->day15 = $day15;

        return $this;
    }

    /**
     * Get day15.
     *
     * @return string|null
     */
    public function getDay15()
    {
        return $this->day15;
    }

    /**
     * Set day16.
     *
     * @param string|null $day16
     *
     * @return Kuadrantea
     */
    public function setDay16($day16 = null)
    {
        $this->day16 = $day16;

        return $this;
    }

    /**
     * Get day16.
     *
     * @return string|null
     */
    public function getDay16()
    {
        return $this->day16;
    }

    /**
     * Set day17.
     *
     * @param string|null $day17
     *
     * @return Kuadrantea
     */
    public function setDay17($day17 = null)
    {
        $this->day17 = $day17;

        return $this;
    }

    /**
     * Get day17.
     *
     * @return string|null
     */
    public function getDay17()
    {
        return $this->day17;
    }

    /**
     * Set day18.
     *
     * @param string|null $day18
     *
     * @return Kuadrantea
     */
    public function setDay18($day18 = null)
    {
        $this->day18 = $day18;

        return $this;
    }

    /**
     * Get day18.
     *
     * @return string|null
     */
    public function getDay18()
    {
        return $this->day18;
    }

    /**
     * Set day19.
     *
     * @param string|null $day19
     *
     * @return Kuadrantea
     */
    public function setDay19($day19 = null)
    {
        $this->day19 = $day19;

        return $this;
    }

    /**
     * Get day19.
     *
     * @return string|null
     */
    public function getDay19()
    {
        return $this->day19;
    }

    /**
     * Set day20.
     *
     * @param string|null $day20
     *
     * @return Kuadrantea
     */
    public function setDay20($day20 = null)
    {
        $this->day20 = $day20;

        return $this;
    }

    /**
     * Get day20.
     *
     * @return string|null
     */
    public function getDay20()
    {
        return $this->day20;
    }

    /**
     * Set day21.
     *
     * @param string|null $day21
     *
     * @return Kuadrantea
     */
    public function setDay21($day21 = null)
    {
        $this->day21 = $day21;

        return $this;
    }

    /**
     * Get day21.
     *
     * @return string|null
     */
    public function getDay21()
    {
        return $this->day21;
    }

    /**
     * Set day22.
     *
     * @param string|null $day22
     *
     * @return Kuadrantea
     */
    public function setDay22($day22 = null)
    {
        $this->day22 = $day22;

        return $this;
    }

    /**
     * Get day22.
     *
     * @return string|null
     */
    public function getDay22()
    {
        return $this->day22;
    }

    /**
     * Set day23.
     *
     * @param string|null $day23
     *
     * @return Kuadrantea
     */
    public function setDay23($day23 = null)
    {
        $this->day23 = $day23;

        return $this;
    }

    /**
     * Get day23.
     *
     * @return string|null
     */
    public function getDay23()
    {
        return $this->day23;
    }

    /**
     * Set day24.
     *
     * @param string|null $day24
     *
     * @return Kuadrantea
     */
    public function setDay24($day24 = null)
    {
        $this->day24 = $day24;

        return $this;
    }

    /**
     * Get day24.
     *
     * @return string|null
     */
    public function getDay24()
    {
        return $this->day24;
    }

    /**
     * Set day25.
     *
     * @param string|null $day25
     *
     * @return Kuadrantea
     */
    public function setDay25($day25 = null)
    {
        $this->day25 = $day25;

        return $this;
    }

    /**
     * Get day25.
     *
     * @return string|null
     */
    public function getDay25()
    {
        return $this->day25;
    }

    /**
     * Set day26.
     *
     * @param string|null $day26
     *
     * @return Kuadrantea
     */
    public function setDay26($day26 = null)
    {
        $this->day26 = $day26;

        return $this;
    }

    /**
     * Get day26.
     *
     * @return string|null
     */
    public function getDay26()
    {
        return $this->day26;
    }

    /**
     * Set day27.
     *
     * @param string|null $day27
     *
     * @return Kuadrantea
     */
    public function setDay27($day27 = null)
    {
        $this->day27 = $day27;

        return $this;
    }

    /**
     * Get day27.
     *
     * @return string|null
     */
    public function getDay27()
    {
        return $this->day27;
    }

    /**
     * Set day28.
     *
     * @param string|null $day28
     *
     * @return Kuadrantea
     */
    public function setDay28($day28 = null)
    {
        $this->day28 = $day28;

        return $this;
    }

    /**
     * Get day28.
     *
     * @return string|null
     */
    public function getDay28()
    {
        return $this->day28;
    }

    /**
     * Set day29.
     *
     * @param string|null $day29
     *
     * @return Kuadrantea
     */
    public function setDay29($day29 = null)
    {
        $this->day29 = $day29;

        return $this;
    }

    /**
     * Get day29.
     *
     * @return string|null
     */
    public function getDay29()
    {
        return $this->day29;
    }

    /**
     * Set day30.
     *
     * @param string|null $day30
     *
     * @return Kuadrantea
     */
    public function setDay30($day30 = null)
    {
        $this->day30 = $day30;

        return $this;
    }

    /**
     * Get day30.
     *
     * @return string|null
     */
    public function getDay30()
    {
        return $this->day30;
    }

    /**
     * Set day31.
     *
     * @param string|null $day31
     *
     * @return Kuadrantea
     */
    public function setDay31($day31 = null)
    {
        $this->day31 = $day31;

        return $this;
    }

    /**
     * Get day31.
     *
     * @return string|null
     */
    public function getDay31()
    {
        return $this->day31;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Kuadrantea
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
     * Set urtea.
     *
     * @param int $urtea
     *
     * @return Kuadrantea
     */
    public function setUrtea($urtea)
    {
        $this->urtea = $urtea;

        return $this;
    }

    /**
     * Get urtea.
     *
     * @return int
     */
    public function getUrtea()
    {
        return $this->urtea;
    }
}
