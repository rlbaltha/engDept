<?php

namespace English\TermBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\TermBundle\Entity\Term
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\TermBundle\Entity\TermRepository")
 */
class Term
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
     * @var string $termName
     *
     * @ORM\Column(name="termName", type="string", length=255)
     */
    private $termName;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;


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
     * Set termName
     *
     * @param string $termName
     */
    public function setTermName($termName)
    {
        $this->termName = $termName;
    }

    /**
     * Get termName
     *
     * @return string 
     */
    public function getTermName()
    {
        return $this->termName;
    }

    /**
     * Set type
     *
     * @param integer $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
}