<?php
// src/Acme/UserBundle/Entity/Order.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="jobs_categoryes")
 */
class JobCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var parent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var url
     * @ORM\Column(type="string", length=100)
     *
     */
    private $url;

    /**
     * @var name
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank(message="Пожалуйста введите название.", groups={"Jobs"})
     */
    private $name;

    /**
     * @var description
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobCategory", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Job", mappedBy="category")
     */
    private $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * @return JobType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param text $description
     * @return JobType
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set url
     *
     * @param string $url
     * @return JobType
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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

        $jobs->setCategory($this);

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


    public function countJobsInChildrens(){
        $children_list = $this->getChildren();
        //var_dump($children_list[0]->getName());
        if($children_list->count()){
            $sum = $this->getJobs()->count();
            foreach($children_list as $children){
                $sum += $children->countJobsInChildrens();
            }
            return $sum;
        }else{
            return $this->getJobs()->count();
        }
    }


    public function getParent() {
        return $this->parent;
    }

    public function getChildren() {
        return $this->children;
    }

    // always use this to setup a new parent/child relationship
    public function addChildren(\AppBundle\Entity\JobCategory $child) {
       $this->children[] = $child;
       $child->setParent($this);
    }

    public function setParent(\AppBundle\Entity\JobCategory $parent) {
       $this->parent = $parent;
    }

    public function __toString(){
        $parent = $this->getParent();

        if (!empty($parent)){
            if ($parent->getId() == $this->getId()){
                return $this->getName() . ' self parent';
            }
            return $this->getParent() . ' - ' . $this->getName();
        } else {
            return $this->getName();
        }
    }
}