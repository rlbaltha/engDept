<?php

namespace English\GradcomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var integer $fid
     *
     * @ORM\Column(name="fid", type="integer")
     */
    private $fid;

    /**
     * @var integer $frole
     *
     * @ORM\Column(name="frole", type="integer")
     */
    private $frole;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
}