<?php
// src/Acme/UserBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @var first_name
     * @ORM\Column(name="fname", type="string", length=200)
     *
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=200,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstName;

     /**
     * @var last_name
     * @ORM\Column(name="lname", type="string", length=100)
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=200,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    /**
     * @var phone
     * @ORM\Column(type="string", length=35)
     *
     */
    protected $phone;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Job", mappedBy="user")
     */
    private $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setPlaceOfBirth($country)
    {
        $this->placeOfBirth = $country;

        return $this;
    }

    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    public function setCountryOfNationality($country)
    {
        $this->countryOfNationality = $country;

        return $this;
    }

    public function getCountryOfNationality()
    {
        return $this->countryOfNationality;
    }



    public function setTaxResidency($country)
    {
        $this->taxResidency = $country;

        return $this;
    }

    public function getTaxResidency()
    {
        return $this->taxResidency;
    }

    public function setDateOfBirth($date)
    {
        $this->dateOfBirth = $date;

        return $this;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setPassportIssueDate($date)
    {
        $this->passportIssueDate = $date;

        return $this;
    }

    public function getPassportIssueDate()
    {
        return $this->passportIssueDate;
    }

    public function setPassportExpiryDate($date)
    {
        $this->passportExpiryDate = $date;

        return $this;
    }

    public function getPassportExpiryDate()
    {
        return $this->passportExpiryDate;
    }

    public function setIsUsaTax($isUsaTax)
    {
        $this->isUsaTax = $isUsaTax;

        return $this;
    }

    public function getIsUsaTax()
    {
        return $this->isUsaTax;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * Add Jobs
     *
     * @param \AppBundle\Entity\Job $jobs
     * @return App
     */
    public function addJobs(\AppBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

        $jobs->setUser($this);

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \AppBundle\Entity\Job $jobs
     */
    public function removeJob(\AppBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }
}
