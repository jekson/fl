<?php
// src/Acme/UserBundle/Entity/Job.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="jobs")
 * @ORM\HasLifecycleCallbacks
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var executor_id
     * @ORM\Column(type="integer", nullabel=true)
     */
    private $executor = null;

     /**
     * @var title
     * @ORM\Column(type="string", length=200)
     *
     * @Assert\NotBlank(message="Пожалуйста введите заголовок.", groups={"Jobs"})
     * @Assert\Length(
     *     min=3,
     *     max=200,
     *     minMessage="Заголовок слишком короткий.",
     *     maxMessage="Заголовок слишком длинный.",
     *     groups={"Jobs"}
     * )
     */
    private $title;

    /**
     * @var price
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var text
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var created
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var status
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @var hidden
     * @ORM\Column(type="boolean")
     */
    private $hidden;

    /**
     * @var onlyPro
     * @ORM\Column(type="boolean")
     */
    private $onlyPro;

    /**
     * @var pay_type
     * @ORM\Column(type="integer")
     */
    private $pay_type;

    /**
     * @var agreement
     * @ORM\Column(type="boolean")
     */
    private $agreement;

    /**
     * @var category
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobCategory", inversedBy="jobs")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    public function __construct()
    {
        $this->hidden = 0;
        $this->pro = 0;
        $this->pay_type = 1;
        $this->status = 1;
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
     * Set title
     *
     * @param string $title
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Job
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Set text
     *
     * @param text $text
     * @return Job
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return text
     */
    public function getText()
    {
        return $this->text;
    }

    public function getShortDescription(){
        return substr($this->text, 0, 210);
    }


    /**
     * Set type
     *
     * @param integer $type
     * @return Job
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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

    /**
     * Set pay_type
     *
     * @param integer $pay_type
     * @return Job
     */
    public function setPayType($pay_type)
    {
        $this->pay_type = $pay_type;

        return $this;
    }

    /**
     * Get pay_type
     *
     * @return integer
     */
    public function getPayType()
    {
        return $this->pay_type;
    }

    /**
     * Set user
     *
     * @param AppBundle\Entity\User $user
     * @return Job
     */
    public function setUser(\AppBundle\Entity\User $user = NULL)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set executor_id
     *
     * @param integer $executor_id
     * @return Job
     */
    public function setExecutorId($executor_id)
    {
        $this->executor_id = $executor_id;

        return $this;
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

    /**
     * Set status
     *
     * @param integer $status
     * @return Job
     */
    public function setJobStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getJobStatus()
    {
        return $this->status;
    }

    /**
     * Set onlyPro
     *
     * @param boolean $onlyPro
     * @return Job
     */
    public function setPro($onlyPro)
    {
        $this->onlyPro = $onlyPro;

        return $this;
    }

    /**
     * Get onlyPro
     *
     * @return boolean
     */
    public function getOnlyPro()
    {
        return $this->onlyPro;
    }

    public function isOnlyPro()
    {
        return $this->onlyPro;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Job
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime('now');

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
     * Set Category
     *
     * @param integer $category
     * @return Job
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set agreement
     *
     * @param boolean $category
     * @return Job
     */
    public function setAgreement($agreement)
    {
        $this->agreement = $agreement;

        return $this;
    }

    /**
     * Get agreement
     *
     * @return boolean
     */
    public function getAgreement()
    {
        return $this->category;
    }
}
