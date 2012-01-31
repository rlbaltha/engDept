<?php

namespace English\MajornotesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\MajornotesBundle\Entity\Majornote
 *
 * @ORM\Table()
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
     * @ORM\Column(name="mentor", type="string", length=255)
     */
    private $mentor;

    /**
     * @var text $notes
     *
     * @ORM\Column(name="notes", type="text")
     */
    private $notes;


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
}