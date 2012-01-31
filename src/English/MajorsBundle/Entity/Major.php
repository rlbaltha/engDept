<?php

namespace English\MajorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string $advisor
     *
     * @ORM\Column(name="advisor", type="string", length=255)
     */
    private $advisor;

    /**
     * @var string $mentorUserName
     *
     * @ORM\Column(name="mentorUserName", type="string", length=255)
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
     * @ORM\Column(name="secondMajor", type="string", length=255)
     */
    private $secondMajor;

    /**
     * @var string $aoe
     *
     * @ORM\Column(name="aoe", type="string", length=255)
     */
    private $aoe;

    /**
     * @var string $can
     *
     * @ORM\Column(name="can", type="string", length=255)
     */
    private $can;

    /**
     * @var string $minor
     *
     * @ORM\Column(name="minor", type="string", length=255)
     */
    private $minor;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var text $notes
     *
     * @ORM\Column(name="notes", type="text")
     */
    private $notes;

    /**
     * @var boolean $honors
     *
     * @ORM\Column(name="honors", type="boolean")
     */
    private $honors;

    /**
     * @var integer $advisorId
     *
     * @ORM\Column(name="advisorId", type="integer")
     */
    private $advisorId;

    /**
     * @var integer $mentorId
     *
     * @ORM\Column(name="mentorId", type="integer")
     */
    private $mentorId;


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
     * Set advisor
     *
     * @param string $advisor
     */
    public function setAdvisor($advisor)
    {
        $this->advisor = $advisor;
    }

    /**
     * Get advisor
     *
     * @return string 
     */
    public function getAdvisor()
    {
        return $this->advisor;
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
}