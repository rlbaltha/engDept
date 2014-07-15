<?php

namespace English\MajornotesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * English\MajornotesBundle\Entity\Majornote
 *
 * @ORM\Table(name="majornote")
 * @ORM\Entity(repositoryClass="English\MajornotesBundle\Entity\MajornoteRepository")
 */
class Majornote
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
     * @var integer $mentorId
     *
     * @ORM\Column(name="mentorId", type="integer")
     */
    private $mentorId;

    /**
     * @var string $mentor
     *
     * @ORM\Column(name="mentor", type="string", length=255, nullable=true)
     */
    private $mentor;

    /**
     * @var text $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

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
     * Set mentor
     *
     * @param string $mentor
     */
    public function setMentor($mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * Get mentor
     *
     * @return string 
     */
    public function getMentor()
    {
        return $this->mentor;
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