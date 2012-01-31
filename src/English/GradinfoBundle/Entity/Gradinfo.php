<?php

namespace English\GradinfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\GradinfoBundle\Entity\Gradinfo
 *
 * @ORM\Table()
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
     * @var integer $gid
     *
     * @ORM\Column(name="gid", type="integer")
     */
    private $gid;

    /**
     * @var string $degree
     *
     * @ORM\Column(name="degree", type="string", length=255)
     */
    private $degree;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
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
     * Set degree
     *
     * @param string $degree
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    }

    /**
     * Get degree
     *
     * @return string 
     */
    public function getDegree()
    {
        return $this->degree;
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
}