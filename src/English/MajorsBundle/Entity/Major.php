<?php

namespace English\MajorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * English\MajorsBundle\Entity\Major
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\MajorsBundle\Entity\MajorRepository")
 */
class Major
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string $mentorUserName
     *
     * @ORM\Column(name="mentorUserName", type="string", length=255, nullable=true)
     */
    private $mentorUserName;

    /**
     * @var string $firstMajor
     *
     * @ORM\Column(name="firstMajor", type="string", length=255)
     */
    private $firstMajor;

    /**
     * @var string $secondMajor
     *
     * @ORM\Column(name="secondMajor", type="string", length=255, nullable=true)
     */
    private $secondMajor;

    /**
     * @var string $aoe
     *
     * @ORM\Column(name="aoe", type="string", length=255, nullable=true)
     */
    private $aoe;

    /**
     * @var string $can
     *
     * @ORM\Column(name="can", type="string", length=255, nullable=true)
     */
    private $can;

    /**
     * @var string $minor
     *
     * @ORM\Column(name="minor", type="string", length=255, nullable=true)
     */
    private $minor;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var text $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var boolean $honors
     *
     * @ORM\Column(name="honors", type="boolean", nullable=true)
     */
    private $honors;

    /**
     * @var integer $advisorId
     *
     * @ORM\Column(name="advisorId", type="integer", nullable=true)
     */
    private $advisorId;

    /**
     * @var integer $mentorId
     *
     * @ORM\Column(name="mentorId", type="integer", nullable=true)
     */
    private $mentorId;

    /**
    * @ORM\ManyToOne(targetEntity="English\AdvisorsBundle\Entity\Advisor", inversedBy="major")
    */
    protected $advisor;
    
    /**
    * @ORM\ManyToOne(targetEntity="English\MentorsBundle\Entity\Mentor", inversedBy="major")
    */
    protected $mentor;  
    
    /**
     * @var integer $userid
     *
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $userid; 
    
    /**
    * @var datetime $mentored
    * @ORM\Column(type="datetime", nullable=true)
    * 
    */
    protected $mentored;  
     
    /**
     * @ORM\OneToOne(targetEntity="Hours")
     * @ORM\JoinColumn(name="can", referencedColumnName="can")
    */
    private $hours;
    
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mentorUserName
     *
     * @param string $mentorUserName
     */
    public function setMentorUserName($mentorUserName)
    {
        $this->mentorUserName = $mentorUserName;
    }

    /**
     * Get mentorUserName
     *
     * @return string 
     */
    public function getMentorUserName()
    {
        return $this->mentorUserName;
    }

    /**
     * Set firstMajor
     *
     * @param string $firstMajor
     */
    public function setFirstMajor($firstMajor)
    {
        $this->firstMajor = $firstMajor;
    }

    /**
     * Get firstMajor
     *
     * @return string 
     */
    public function getFirstMajor()
    {
        return $this->firstMajor;
    }

    /**
     * Set secondMajor
     *
     * @param string $secondMajor
     */
    public function setSecondMajor($secondMajor)
    {
        $this->secondMajor = $secondMajor;
    }

    /**
     * Get secondMajor
     *
     * @return string 
     */
    public function getSecondMajor()
    {
        return $this->secondMajor;
    }

    /**
     * Set aoe
     *
     * @param string $aoe
     */
    public function setAoe($aoe)
    {
        $this->aoe = $aoe;
    }

    /**
     * Get aoe
     *
     * @return string 
     */
    public function getAoe()
    {
        return $this->aoe;
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
     * Set minor
     *
     * @param string $minor
     */
    public function setMinor($minor)
    {
        $this->minor = $minor;
    }

    /**
     * Get minor
     *
     * @return string 
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set notes
     *
     * @param text $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return text 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set honors
     *
     * @param boolean $honors
     */
    public function setHonors($honors)
    {
        $this->honors = $honors;
    }

    /**
     * Get honors
     *
     * @return boolean 
     */
    public function getHonors()
    {
        return $this->honors;
    }

    /**
     * Set advisorId
     *
     * @param integer $advisorId
     */
    public function setAdvisorId($advisorId)
    {
        $this->advisorId = $advisorId;
    }

    /**
     * Get advisorId
     *
     * @return integer 
     */
    public function getAdvisorId()
    {
        return $this->advisorId;
    }

    /**
     * Set mentorId
     *
     * @param integer $mentorId
     */
    public function setMentorId($mentorId)
    {
        $this->mentorId = $mentorId;
    }

    /**
     * Get mentorId
     *
     * @return integer 
     */
    public function getMentorId()
    {
        return $this->mentorId;
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
     * Set advisor
     *
     * @param English\AdvisorsBundle\Entity\Advisor $advisor
     */
    public function setAdvisor(\English\AdvisorsBundle\Entity\Advisor $advisor)
    {
        $this->advisor = $advisor;
    }

    /**
     * Get advisor
     *
     * @return English\AdvisorsBundle\Entity\Advisor 
     */
    public function getAdvisor()
    {
        return $this->advisor;
    }

    /**
     * Set mentor
     *
     * @param English\MentorsBundle\Entity\Mentor $mentor
     */
    public function setMentor(\English\MentorsBundle\Entity\Mentor $mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * Get mentor
     *
     * @return English\MentorsBundle\Entity\Mentor 
     */
    public function getMentor()
    {
        return $this->mentor;
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

    /**
     * Set mentored
     *
     * @param datetime $mentored
     */
    public function setMentored($mentored)
    {
        $this->mentored = $mentored;
    }

    /**
     * Get mentored
     *
     * @return datetime 
     */
    public function getMentored()
    {
        return $this->mentored;
    }


    /**
     * Set hours
     *
     * @param English\MajorsBundle\Entity\Hours $hours
     */
    public function setHours(\English\MajorsBundle\Entity\Hours $hours)
    {
        $this->hours = $hours;
    }

    /**
     * Get hours
     *
     * @return English\MajorsBundle\Entity\Hours 
     */
    public function getHours()
    {
        return $this->hours;
    }
}