<?php

namespace English\DawgspeakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\DawgspeakBundle\Entity\Def
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\DawgspeakBundle\Entity\DefRepository")
 */
class Def
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
     * @var string $term
     *
     * @ORM\Column(name="term", type="string", length=255)
     */
    private $term;

    /**
     * @var string $pos1
     *
     * @ORM\Column(name="pos1", type="string", length=255)
     */
    private $pos1;

    /**
     * @var text $def1
     *
     * @ORM\Column(name="def1", type="text")
     */
    private $def1;

    /**
     * @var string $pos2
     *
     * @ORM\Column(name="pos2", type="string", length=255)
     */
    private $pos2;

    /**
     * @var text $def2
     *
     * @ORM\Column(name="def2", type="text")
     */
    private $def2;

    /**
     * @var string $pos3
     *
     * @ORM\Column(name="pos3", type="string", length=255)
     */
    private $pos3;

    /**
     * @var text $def3
     *
     * @ORM\Column(name="def3", type="text")
     */
    private $def3;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string $ref
     *
     * @ORM\Column(name="ref", type="string", length=255)
     */
    private $ref;

    /**
     * @var text $etymology
     *
     * @ORM\Column(name="etymology", type="text")
     */
    private $etymology;


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
     * Set term
     *
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * Get term
     *
     * @return string 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set pos1
     *
     * @param string $pos1
     */
    public function setPos1($pos1)
    {
        $this->pos1 = $pos1;
    }

    /**
     * Get pos1
     *
     * @return string 
     */
    public function getPos1()
    {
        return $this->pos1;
    }

    /**
     * Set def1
     *
     * @param text $def1
     */
    public function setDef1($def1)
    {
        $this->def1 = $def1;
    }

    /**
     * Get def1
     *
     * @return text 
     */
    public function getDef1()
    {
        return $this->def1;
    }

    /**
     * Set pos2
     *
     * @param string $pos2
     */
    public function setPos2($pos2)
    {
        $this->pos2 = $pos2;
    }

    /**
     * Get pos2
     *
     * @return string 
     */
    public function getPos2()
    {
        return $this->pos2;
    }

    /**
     * Set def2
     *
     * @param text $def2
     */
    public function setDef2($def2)
    {
        $this->def2 = $def2;
    }

    /**
     * Get def2
     *
     * @return text 
     */
    public function getDef2()
    {
        return $this->def2;
    }

    /**
     * Set pos3
     *
     * @param string $pos3
     */
    public function setPos3($pos3)
    {
        $this->pos3 = $pos3;
    }

    /**
     * Get pos3
     *
     * @return string 
     */
    public function getPos3()
    {
        return $this->pos3;
    }

    /**
     * Set def3
     *
     * @param text $def3
     */
    public function setDef3($def3)
    {
        $this->def3 = $def3;
    }

    /**
     * Get def3
     *
     * @return text 
     */
    public function getDef3()
    {
        return $this->def3;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set ref
     *
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set etymology
     *
     * @param text $etymology
     */
    public function setEtymology($etymology)
    {
        $this->etymology = $etymology;
    }

    /**
     * Get etymology
     *
     * @return text 
     */
    public function getEtymology()
    {
        return $this->etymology;
    }
}