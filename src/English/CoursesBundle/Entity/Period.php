<?php

namespace English\CoursesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Period
 *
 * @ORM\Table(name="period")
 * @ORM\Entity(repositoryClass="English\CoursesBundle\Entity\PeriodRepository")
 */
class Period
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="daytime", type="string", length=255)
     */
    private $daytime;


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
     * Set number
     *
     * @param string $number
     * @return Period
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set daytime
     *
     * @param string $daytime
     * @return Period
     */
    public function setDaytime($daytime)
    {
        $this->daytime = $daytime;

        return $this;
    }

    /**
     * Get daytime
     *
     * @return string 
     */
    public function getDaytime()
    {
        return $this->daytime;
    }
}
