<?php

namespace English\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detail
 *
 * @ORM\Table(name="detail")
 * @ORM\Entity(repositoryClass="English\PeopleBundle\Entity\DetailRepository")
 */
class Detail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \string
     *
     * @ORM\Column(name="startdate", type="string", length=255, nullable=true)
     */
    private $startdate;

    /**
     * @var \string
     *
     * @ORM\Column(name="enddate", type="string", length=255, nullable=true)
     */
    private $enddate;

    /**
     * @var string
     *
     * @ORM\Column(name="accomplishments", type="text", nullable=true)
     */
    private $accomplishments;

    /**
     * @var \string
     *
     * @ORM\Column(name="appcompleted", type="string", length=255, nullable=true)
     */
    private $appCompleted = 'no';

    /**
     * @var \string
     *
     * @ORM\Column(name="appWith", type="string", length=255, nullable=true)
     */
    private $appWith;

    /**
     * @var string
     *
     * @ORM\Column(name="placement", type="text", nullable=true)
     */
    private $placement;

    /**
     * @var string
     *
     * @ORM\Column(name="courseloadf", type="string", length=255, nullable=true)
     */
    private $courseloadF = 2;

    /**
     * @var string
     *
     * @ORM\Column(name="courseloads", type="string", length=255, nullable=true)
     */
    private $courseloadS = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="home_dept", type="string", length=255, nullable=true)
     */
    private $homeDept = 'Eng';


    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;



    /**
     * @ORM\OneToOne(targetEntity="English\PeopleBundle\Entity\People", inversedBy="detail")
     *
     */
    private $people;

    /**
     * @ORM\ManyToOne(targetEntity="English\TermBundle\Entity\Term")
     *
     */
    private $startterm;

    /**
     * @ORM\ManyToOne(targetEntity="English\TermBundle\Entity\Term")
     *
     */
    private $endterm;

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
     * Set startdate
     *
     * @param \DateTime $startdate
     * @return Detail
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }


    /**
     * Set accomplishments
     *
     * @param string $accomplishments
     * @return Detail
     */
    public function setAccomplishments($accomplishments)
    {
        $this->accomplishments = $accomplishments;

        return $this;
    }

    /**
     * Get accomplishments
     *
     * @return string 
     */
    public function getAccomplishments()
    {
        return $this->accomplishments;
    }


    /**
     * Set placement
     *
     * @param string $placement
     * @return Detail
     */
    public function setPlacement($placement)
    {
        $this->placement = $placement;

        return $this;
    }

    /**
     * Get placement
     *
     * @return string 
     */
    public function getPlacement()
    {
        return $this->placement;
    }

    /**
     * Set homeDept
     *
     * @param string $homeDept
     * @return Detail
     */
    public function setHomeDept($homeDept)
    {
        $this->homeDept = $homeDept;

        return $this;
    }

    /**
     * Get homeDept
     *
     * @return string 
     */
    public function getHomeDept()
    {
        return $this->homeDept;
    }

    /**
     * Set courseloadF
     *
     * @param string $courseloadF
     * @return Detail
     */
    public function setCourseloadF($courseloadF)
    {
        $this->courseloadF = $courseloadF;

        return $this;
    }

    /**
     * Get courseloadF
     *
     * @return string 
     */
    public function getCourseloadF()
    {
        return $this->courseloadF;
    }

    /**
     * Set courseloadS
     *
     * @param string $courseloadS
     * @return Detail
     */
    public function setCourseloadS($courseloadS)
    {
        $this->courseloadS = $courseloadS;

        return $this;
    }

    /**
     * Get courseloadS
     *
     * @return string 
     */
    public function getCourseloadS()
    {
        return $this->courseloadS;
    }

    /**
     * Set people
     *
     * @param \English\PeopleBundle\Entity\People $people
     * @return Detail
     */
    public function setPeople(\English\PeopleBundle\Entity\People $people = null)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return \English\PeopleBundle\Entity\People 
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Detail
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }


    /**
     * Set appCompleted
     *
     * @param string $appCompleted
     * @return Detail
     */
    public function setAppCompleted($appCompleted)
    {
        $this->appCompleted = $appCompleted;

        return $this;
    }

    /**
     * Get appCompleted
     *
     * @return string 
     */
    public function getAppCompleted()
    {
        return $this->appCompleted;
    }

    /**
     * Set appWith
     *
     * @param string $appWith
     * @return Detail
     */
    public function setAppWith($appWith)
    {
        $this->appWith = $appWith;

        return $this;
    }

    /**
     * Get appWith
     *
     * @return string 
     */
    public function getAppWith()
    {
        return $this->appWith;
    }



    /**
     * Set endterm
     *
     * @param \English\TermBundle\Entity\Term $endterm
     * @return Detail
     */
    public function setEndterm(\English\TermBundle\Entity\Term $endterm = null)
    {
        $this->endterm = $endterm;

        return $this;
    }

    /**
     * Get endterm
     *
     * @return \English\TermBundle\Entity\Term 
     */
    public function getEndterm()
    {
        return $this->endterm;
    }

    /**
     * Get startdate
     *
     * @return string 
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param string $enddate
     * @return Detail
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return string 
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set startterm
     *
     * @param \English\TermBundle\Entity\Term $startterm
     * @return Detail
     */
    public function setStartterm(\English\TermBundle\Entity\Term $startterm = null)
    {
        $this->startterm = $startterm;

        return $this;
    }

    /**
     * Get startterm
     *
     * @return \English\TermBundle\Entity\Term 
     */
    public function getStartterm()
    {
        return $this->startterm;
    }
}
