<?php

namespace English\PositionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\PositionBundle\Entity\Position
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\PositionBundle\Entity\PositionRepository")
 */
class Position
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
     * @var string $position
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;


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
     * Set position
     *
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }
}