<?php

namespace English\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page
 *
 * @ORM\Table(name="web_page")
 * @ORM\Entity(repositoryClass="English\PagesBundle\Entity\PageRepository")
 */
class Page
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
     * @ORM\ManyToOne(targetEntity="English\PeopleBundle\Entity\People", inversedBy="pages")
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_name", type="string", length=255)
     */
    private $menuName;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="on_nav", type="string", length=255, nullable=true)
     */
    private $on_nav='0';

    /**
     * @var string
     *
     * @ORM\Column(name="page_body", type="text", nullable=true)
     */
    private $pageBody;


    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     * @ORM\OrderBy({"sortorder" = "ASC"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="pages")
     */
    protected $section;


    /**
     * @var integer $sortOrder
     *
     * @ORM\Column(name="sortorder", type="integer", nullable=true)
     */
    private $sortorder;


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
     * Set menuName
     *
     * @param string $menuName
     * @return Page
     */
    public function setMenuName($menuName)
    {
        $this->menuName = $menuName;

        return $this;
    }

    /**
     * Get menuName
     *
     * @return string 
     */
    public function getMenuName()
    {
        return $this->menuName;
    }

    /**
     * Set pageBody
     *
     * @param string $pageBody
     * @return Page
     */
    public function setPageBody($pageBody)
    {
        $this->pageBody = $pageBody;

        return $this;
    }

    /**
     * Get pageBody
     *
     * @return string 
     */
    public function getPageBody()
    {
        return $this->pageBody;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Page
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Page
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add children
     *
     * @param \English\PagesBundle\Entity\Page $children
     * @return Page
     */
    public function addChild(\English\PagesBundle\Entity\Page $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \English\PagesBundle\Entity\Page $children
     */
    public function removeChild(\English\PagesBundle\Entity\Page $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \English\PagesBundle\Entity\Page $parent
     * @return Page
     */
    public function setParent(\English\PagesBundle\Entity\Page $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \English\PagesBundle\Entity\Page 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set section
     *
     * @param \English\PagesBundle\Entity\Section $section
     * @return Page
     */
    public function setSection(\English\PagesBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \English\PagesBundle\Entity\Section 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Page
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set sortorder
     *
     * @param integer $sortorder
     * @return Page
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;

        return $this;
    }

    /**
     * Get sortorder
     *
     * @return integer 
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }

    /**
     * Set user
     *
     * @param \English\PeopleBundle\Entity\People $user
     * @return Page
     */
    public function setUser(\English\PeopleBundle\Entity\People $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \English\PeopleBundle\Entity\People 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set on_nav
     *
     * @param string $onNav
     * @return Page
     */
    public function setOnNav($onNav)
    {
        $this->on_nav = $onNav;

        return $this;
    }

    /**
     * Get on_nav
     *
     * @return string 
     */
    public function getOnNav()
    {
        return $this->on_nav;
    }
}
