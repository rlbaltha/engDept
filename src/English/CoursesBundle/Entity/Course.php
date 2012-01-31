<?php

namespace English\CoursesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\CoursesBundle\Entity\Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\CoursesBundle\Entity\CourseRepository")
 */
class Course
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
     * @var string $courseName
     *
     * @ORM\Column(name="courseName", type="string", length=255)
     */
    private $courseName;

    /**
     * @var string $instructorName
     *
     * @ORM\Column(name="instructorName", type="string", length=255)
     */
    private $instructorName;

    /**
     * @var string $callNumber
     *
     * @ORM\Column(name="callNumber", type="string", length=255)
     */
    private $callNumber;

    /**
     * @var string $room
     *
     * @ORM\Column(name="room", type="string", length=255)
     */
    private $room;

    /**
     * @var string $days
     *
     * @ORM\Column(name="days", type="string", length=255)
     */
    private $days;

    /**
     * @var string $term
     *
     * @ORM\Column(name="term", type="string", length=255)
     */
    private $term;

    /**
     * @var string $time
     *
     * @ORM\Column(name="time", type="string", length=255)
     */
    private $time;

    /**
     * @var string $building
     *
     * @ORM\Column(name="building", type="string", length=255)
     */
    private $building;

    /**
     * @var string $callNumber2
     *
     * @ORM\Column(name="callNumber2", type="string", length=255)
     */
    private $callNumber2;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string $period
     *
     * @ORM\Column(name="period", type="string", length=255)
     */
    private $period;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $area
     *
     * @ORM\Column(name="area", type="string", length=255)
     */
    private $area;

    /**
     * @var boolean $may
     *
     * @ORM\Column(name="may", type="boolean")
     */
    private $may;


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
     * Set courseName
     *
     * @param string $courseName
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;
    }

    /**
     * Get courseName
     *
     * @return string 
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * Set instructorName
     *
     * @param string $instructorName
     */
    public function setInstructorName($instructorName)
    {
        $this->instructorName = $instructorName;
    }

    /**
     * Get instructorName
     *
     * @return string 
     */
    public function getInstructorName()
    {
        return $this->instructorName;
    }

    /**
     * Set callNumber
     *
     * @param string $callNumber
     */
    public function setCallNumber($callNumber)
    {
        $this->callNumber = $callNumber;
    }

    /**
     * Get callNumber
     *
     * @return string 
     */
    public function getCallNumber()
    {
        return $this->callNumber;
    }

    /**
     * Set room
     *
     * @param string $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * Get room
     *
     * @return string 
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set days
     *
     * @param string $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * Get days
     *
     * @return string 
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set term
     *
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * Get term
     *
     * @return string 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set time
     *
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return string 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set building
     *
     * @param string $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set callNumber2
     *
     * @param string $callNumber2
     */
    public function setCallNumber2($callNumber2)
    {
        $this->callNumber2 = $callNumber2;
    }

    /**
     * Get callNumber2
     *
     * @return string 
     */
    public function getCallNumber2()
    {
        return $this->callNumber2;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set period
     *
     * @param string $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * Get period
     *
     * @return string 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set area
     *
     * @param string $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set may
     *
     * @param boolean $may
     */
    public function setMay($may)
    {
        $this->may = $may;
    }

    /**
     * Get may
     *
     * @return boolean 
     */
    public function getMay()
    {
        return $this->may;
    }
}