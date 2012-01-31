<?php

namespace English\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * English\PeopleBundle\Entity\People
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="English\PeopleBundle\Entity\PeopleRepository")
 */
class People
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
     * @var string $lastName
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string $firstName
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var text $title
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string $rank
     *
     * @ORM\Column(name="rank", type="string", length=255)
     */
    private $rank;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string $address2
     *
     * @ORM\Column(name="address2", type="string", length=255)
     */
    private $address2;

    /**
     * @var string $vitaUrl
     *
     * @ORM\Column(name="vitaUrl", type="string", length=255)
     */
    private $vitaUrl;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var text $officeHours
     *
     * @ORM\Column(name="officeHours", type="text")
     */
    private $officeHours;

    /**
     * @var string $spouse
     *
     * @ORM\Column(name="spouse", type="string", length=255)
     */
    private $spouse;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string $homePhone
     *
     * @ORM\Column(name="homePhone", type="string", length=255)
     */
    private $homePhone;

    /**
     * @var string $cellPhone
     *
     * @ORM\Column(name="cellPhone", type="string", length=255)
     */
    private $cellPhone;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string $officeNumber
     *
     * @ORM\Column(name="officeNumber", type="string", length=255)
     */
    private $officeNumber;

    /**
     * @var string $officePhone
     *
     * @ORM\Column(name="officePhone", type="string", length=255)
     */
    private $officePhone;

    /**
     * @var string $photoUrl
     *
     * @ORM\Column(name="photoUrl", type="string", length=255)
     */
    private $photoUrl;

    /**
     * @var text $bio
     *
     * @ORM\Column(name="bio", type="text")
     */
    private $bio;

    /**
     * @var text $area
     *
     * @ORM\Column(name="area", type="text")
     */
    private $area;

    /**
     * @var string $homepageUrl
     *
     * @ORM\Column(name="homepageUrl", type="string", length=255)
     */
    private $homepageUrl;

    /**
     * @var integer $active
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;

    /**
     * @var text $position
     *
     * @ORM\Column(name="position", type="text")
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
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return text 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set rank
     *
     * @param string $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set vitaUrl
     *
     * @param string $vitaUrl
     */
    public function setVitaUrl($vitaUrl)
    {
        $this->vitaUrl = $vitaUrl;
    }

    /**
     * Get vitaUrl
     *
     * @return string 
     */
    public function getVitaUrl()
    {
        return $this->vitaUrl;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set officeHours
     *
     * @param text $officeHours
     */
    public function setOfficeHours($officeHours)
    {
        $this->officeHours = $officeHours;
    }

    /**
     * Get officeHours
     *
     * @return text 
     */
    public function getOfficeHours()
    {
        return $this->officeHours;
    }

    /**
     * Set spouse
     *
     * @param string $spouse
     */
    public function setSpouse($spouse)
    {
        $this->spouse = $spouse;
    }

    /**
     * Get spouse
     *
     * @return string 
     */
    public function getSpouse()
    {
        return $this->spouse;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set homePhone
     *
     * @param string $homePhone
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;
    }

    /**
     * Get homePhone
     *
     * @return string 
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * Set cellPhone
     *
     * @param string $cellPhone
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;
    }

    /**
     * Get cellPhone
     *
     * @return string 
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set officeNumber
     *
     * @param string $officeNumber
     */
    public function setOfficeNumber($officeNumber)
    {
        $this->officeNumber = $officeNumber;
    }

    /**
     * Get officeNumber
     *
     * @return string 
     */
    public function getOfficeNumber()
    {
        return $this->officeNumber;
    }

    /**
     * Set officePhone
     *
     * @param string $officePhone
     */
    public function setOfficePhone($officePhone)
    {
        $this->officePhone = $officePhone;
    }

    /**
     * Get officePhone
     *
     * @return string 
     */
    public function getOfficePhone()
    {
        return $this->officePhone;
    }

    /**
     * Set photoUrl
     *
     * @param string $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * Get photoUrl
     *
     * @return string 
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * Set bio
     *
     * @param text $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * Get bio
     *
     * @return text 
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set area
     *
     * @param text $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * Get area
     *
     * @return text 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set homepageUrl
     *
     * @param string $homepageUrl
     */
    public function setHomepageUrl($homepageUrl)
    {
        $this->homepageUrl = $homepageUrl;
    }

    /**
     * Get homepageUrl
     *
     * @return string 
     */
    public function getHomepageUrl()
    {
        return $this->homepageUrl;
    }

    /**
     * Set active
     *
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set position
     *
     * @param text $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return text 
     */
    public function getPosition()
    {
        return $this->position;
    }

}