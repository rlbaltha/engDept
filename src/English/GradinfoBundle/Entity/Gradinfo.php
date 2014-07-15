<?php

namespace English\GradinfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * English\GradinfoBundle\Entity\Gradinfo
 *
 * @ORM\Table(name="gradinfo")
 * @ORM\Entity(repositoryClass="English\GradinfoBundle\Entity\GradinfoRepository")
 */
class Gradinfo
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
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var integer $userid
     *
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $userid; 
    

    /**
     * @ORM\OneToMany(targetEntity="English\PeopleBundle\Entity\People", mappedBy="gradinfo" )
     */
    protected $people;

    public function __construct()
    {
        $this->people = new ArrayCollection();
    }    
    
    
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

    /**
     * Add people
     *
     * @param English\PeopleBundle\Entity\People $people
     */
    public function addPeople(\English\PeopleBundle\Entity\People $people)
    {
        $this->people[] = $people;
    }

    /**
     * Get people
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPeople()
    {
        return $this->people;
    }
}