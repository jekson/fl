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
     * @var author_id
     * @ORM\Column(type="integer")
     */
    private $author_id;

    /**
     * @var executor_id
     * @ORM\Column(type="integer")
     */
    private $executor_id;

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
     * @ORM\Column(type="integer")
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

    public function __construct()
    {
        parent::__construct();
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
     * @param integer $text
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
     * Set author_id
     *
     * @param integer $author_id
     * @return Job
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Get author_id
     *
     * @return integer
     */
    public function getAuthorId()
    {
        return $this->author_id;
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
     * Set created
     *
     * @param \DateTime $created
     * @return Job
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new DateTime('now');

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
}
