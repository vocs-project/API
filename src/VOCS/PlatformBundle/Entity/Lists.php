<?php

namespace VOCS\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Lists
 *
 * @ORM\Table(name="lists")
 * @ORM\Entity(repositoryClass="VOCS\PlatformBundle\Repository\ListsRepository")
 */
class Lists
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;


    /**
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="lists")
     */
    private $users;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="WordTrad", cascade={"remove"})
     * @ORM\JoinTable(name="list_wordTrad",
     *      joinColumns={@ORM\JoinColumn(name="list_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="wordTrad_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    private $wordTrads;


    /**
     *
     * @ORM\ManyToMany(targetEntity="Classes", mappedBy="lists")
     */
    private $classes;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Lists
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Lists
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wordTrads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreationDate(new \DateTime());
    }


    /**
     * Add user
     *
     * @param \VOCS\PlatformBundle\Entity\User $user
     *
     * @return Lists
     */
    public function addUser(\VOCS\PlatformBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \VOCS\PlatformBundle\Entity\User $user
     */
    public function removeUser(\VOCS\PlatformBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add wordTrad
     *
     * @param \VOCS\PlatformBundle\Entity\WordTrad $wordTrad
     *
     * @return Lists
     */
    public function addWordTrad(\VOCS\PlatformBundle\Entity\WordTrad $wordTrad)
    {
        $this->wordTrads[] = $wordTrad;

        return $this;
    }

    /**
     * Remove wordTrad
     *
     * @param \VOCS\PlatformBundle\Entity\WordTrad $wordTrad
     */
    public function removeWordTrad(\VOCS\PlatformBundle\Entity\WordTrad $wordTrad)
    {
        $this->wordTrads->removeElement($wordTrad);
    }

    /**
     * Get wordTrads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWordTrads()
    {
        return $this->wordTrads;
    }

    /**
     * Add class
     *
     * @param \VOCS\PlatformBundle\Entity\Classes $class
     *
     * @return Lists
     */
    public function addClass(\VOCS\PlatformBundle\Entity\Classes $class)
    {
        $this->classes->add($class);
        return $this;
    }

    /**
     * Remove class
     *
     * @param \VOCS\PlatformBundle\Entity\Classes $class
     */
    public function removeClass(\VOCS\PlatformBundle\Entity\Classes $class)
    {
        $this->classes->removeElement($class);
    }

    /**
     * Get classes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }
}
