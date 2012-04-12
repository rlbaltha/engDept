<?php

namespace English\MajorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\MajorsBundle\Entity\Hours
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\MajorsBundle\Entity\HoursRepository")
 */
class Hours
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $can
     *
     * @ORM\Column(name="can", type="string", length=255, unique=TRUE)
     */
    private $can;

    /**
     * @var integer $hours
     *
     * @ORM\Column(name="hours", type="integer")
     */
    private $hours;

    /**
     * @var decimal $gpa
     *
     * @ORM\Column(name="gpa", type="decimal")
     */
    private $gpa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Major", inversedBy="hours")
     * @ORM\JoinColumn(name="can", referencedColumnName="can")
     * 
     */
    private $major;    
    


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
     * Set can
     *
     * @param string $can
     */
    public function setCan($can)
    {
        $this->can = $can;
    }

    /**
     * Get can
     *
     * @return string 
     */
    public function getCan()
    {
        return $this->can;
    }

    /**
     * Set hours
     *
     * @param integer $hours
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
    }

    /**
     * Get hours
     *
     * @return integer 
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set gpa
     *
     * @param decimal $gpa
     */
    public function setGpa($gpa)
    {
        $this->gpa = $gpa;
    }

    /**
     * Get gpa
     *
     * @return decimal 
     */
    public function getGpa()
    {
        return $this->gpa;
    }


    /**
     * Set major
     *
     * @param English\MajorsBundle\Entity\Major $major
     */
    public function setMajor(\English\MajorsBundle\Entity\Major $major)
    {
        $this->major = $major;
    }

    /**
     * Get major
     *
     * @return English\MajorsBundle\Entity\Major 
     */
    public function getMajor()
    {
        return $this->major;
    }
}