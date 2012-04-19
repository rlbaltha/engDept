<?php

namespace English\GradcomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * English\GradcomBundle\Entity\Gradcom
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\GradcomBundle\Entity\GradcomRepository")
 */
class Gradcom
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
     * @var string $fid
     *
     * @ORM\Column(name="fid", type="string", length=255)
     */
    private $fid;
    
    /**
     * @ORM\ManyToOne(targetEntity="English\PeopleBundle\Entity\People", inversedBy="gradcom")
     * @ORM\JoinColumn(name="gradcom_id", referencedColumnName="id")
     */
    protected $people;  
    
    /**
     * @ORM\ManyToOne(targetEntity="English\PeopleBundle\Entity\People", inversedBy="grad")
     * @ORM\JoinColumn(name="grad_id", referencedColumnName="id")
     */
    protected $grad;      

    /**
     * @var integer $frole
     *
     * @ORM\Column(name="frole", type="integer", nullable=true)
     */
    private $frole;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

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
     * Set fid
     *
     * @param integer $fid
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
    }

    /**
     * Get fid
     *
     * @return integer 
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * Set frole
     *
     * @param integer $frole
     */
    public function setFrole($frole)
    {
        $this->frole = $frole;
    }

    /**
     * Get frole
     *
     * @return integer 
     */
    public function getFrole()
    {
        return $this->frole;
    }

    /**
     * Set status
     *
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return boolean 
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
     * Set people
     *
     * @param English\PeopleBundle\Entity\People $people
     */
    public function setPeople(\English\PeopleBundle\Entity\People $people)
    {
        $this->people = $people;
    }

    /**
     * Get people
     *
     * @return English\PeopleBundle\Entity\People 
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set grad
     *
     * @param English\PeopleBundle\Entity\People $grad
     */
    public function setGrad(\English\PeopleBundle\Entity\People $grad)
    {
        $this->grad = $grad;
    }

    /**
     * Get grad
     *
     * @return English\PeopleBundle\Entity\People 
     */
    public function getGrad()
    {
        return $this->grad;
    }
}