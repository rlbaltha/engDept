<?php

namespace English\GradnotesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\GradnotesBundle\Entity\Gradnotes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\GradnotesBundle\Entity\GradnotesRepository")
 */
class Gradnotes
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
     * @var integer $gid
     *
     * @ORM\Column(name="gid", type="integer")
     */
    private $gid;

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
     * Set gid
     *
     * @param integer $gid
     */
    public function setGid($gid)
    {
        $this->gid = $gid;
    }

    /**
     * Get gid
     *
     * @return integer 
     */
    public function getGid()
    {
        return $this->gid;
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