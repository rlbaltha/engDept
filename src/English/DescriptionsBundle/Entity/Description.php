<?php

namespace English\DescriptionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * English\DescriptionsBundle\Entity\Description
 *
 * @ORM\Table(name="description")
 * @ORM\Entity(repositoryClass="English\DescriptionsBundle\Entity\DescriptionRepository")
 */
class Description
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
     * @var string $callNumber
     *
     * @ORM\Column(name="callNumber", type="string", length=255)
     */
    private $callNumber;

    /**
     * @var string $term
     *
     * @ORM\Column(name="term", type="string", length=255, nullable=true)
     */
    private $term;

    /**
     * @var string $course
     *
     * @ORM\Column(name="course", type="string", length=255, nullable=true)
     */
    private $course;

    /**
     * @var string $instructorName
     *
     * @ORM\Column(name="instructorName", type="string", length=255, nullable=true)
     */
    private $instructorName;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var text $assignments
     *
     * @ORM\Column(name="assignments", type="text", nullable=true)
     */
    private $assignments;

    /**
     * @var text $requirements
     *
     * @ORM\Column(name="requirements", type="text", nullable=true)
     */
    private $requirements;

    /**
     * @var text $grading
     *
     * @ORM\Column(name="grading", type="text", nullable=true)
     */
    private $grading;

    /**
     * @var text $attendance
     *
     * @ORM\Column(name="attendance", type="text", nullable=true)
     */
    private $attendance;

    /**
     * @var text $material
     *
     * @ORM\Column(name="material", type="text", nullable=true)
     */
    private $material;

    /**
     * @var text $makeup
     *
     * @ORM\Column(name="makeup", type="text", nullable=true)
     */
    private $makeup;

    /**
     * @var text $url
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @var text $topicsTitle
     *
     * @ORM\Column(name="topicsTitle", type="text", nullable=true)
     */
    private $topicsTitle;

    /**
     * @var text $topics
     *
     * @ORM\Column(name="topics", type="text", nullable=true)
     */
    private $topics;
     
    /**
     * @var integer $userid
     *
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $userid; 
    
    /**
    * @ORM\Column(type="datetime", nullable=true)
    * @Gedmo\Timestampable(on="create")
    */
    protected $created;
    
    /**
    * @ORM\Column(type="datetime", nullable=true)
    * @Gedmo\Timestampable(on="update")
    */
    protected $updated;
    
    
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
     * Set course
     *
     * @param string $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * Get course
     *
     * @return string 
     */
    public function getCourse()
    {
        return $this->course;
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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set assignments
     *
     * @param text $assignments
     */
    public function setAssignments($assignments)
    {
        $this->assignments = $assignments;
    }

    /**
     * Get assignments
     *
     * @return text 
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Set requirements
     *
     * @param text $requirements
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
    }

    /**
     * Get requirements
     *
     * @return text 
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Set grading
     *
     * @param text $grading
     */
    public function setGrading($grading)
    {
        $this->grading = $grading;
    }

    /**
     * Get grading
     *
     * @return text 
     */
    public function getGrading()
    {
        return $this->grading;
    }

    /**
     * Set attendance
     *
     * @param text $attendance
     */
    public function setAttendance($attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Get attendance
     *
     * @return text 
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * Set material
     *
     * @param text $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * Get material
     *
     * @return text 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set makeup
     *
     * @param text $makeup
     */
    public function setMakeup($makeup)
    {
        $this->makeup = $makeup;
    }

    /**
     * Get makeup
     *
     * @return text 
     */
    public function getMakeup()
    {
        return $this->makeup;
    }

    /**
     * Set url
     *
     * @param text $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return text 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set topicsTitle
     *
     * @param text $topicsTitle
     */
    public function setTopicsTitle($topicsTitle)
    {
        $this->topicsTitle = $topicsTitle;
    }

    /**
     * Get topicsTitle
     *
     * @return text 
     */
    public function getTopicsTitle()
    {
        return $this->topicsTitle;
    }

    /**
     * Set topics
     *
     * @param text $topics
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
    }

    /**
     * Get topics
     *
     * @return text 
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}