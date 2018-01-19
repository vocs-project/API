<?php

namespace VOCS\PlatformBundle\Entity;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classes
 *
 * @ORM\Table(name="classes")
 * @ORM\Entity(repositoryClass="VOCS\PlatformBundle\Repository\ClassesRepository")
 */
class Classes implements ObjectManagerAware
{
    /**
     * Identifiant de la classe
     *
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
     *
     * @ORM\ManyToOne(targetEntity="Schools", inversedBy="classes")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id")
     */
    private $school;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="classes", cascade={"persist", "merge"})
     */
    private $users;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Lists", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="classes_lists",
     *      joinColumns={@ORM\JoinColumn(name="classes_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="lists_id", referencedColumnName="id")}
     *      )
     */
    private $lists;

    /**
     * @var string
     *
     * @ORM\Column(name="url_avatar", type="string", length=255, nullable=true)
     */
    private $urlAvatar;


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
     * @return Classes
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
     * Set urlAvatar
     *
     * @param string $urlAvatar
     *
     * @return Classes
     */
    public function setUrlAvatar($urlAvatar)
    {
        $this->urlAvatar = $urlAvatar;

        return $this;
    }

    /**
     * Get urlAvatar
     *
     * @return string
     */
    public function getUrlAvatar()
    {
        return $this->urlAvatar;
    }

    /**
     * Set school
     *
     * @param \VOCS\PlatformBundle\Entity\Schools $school
     *
     * @return Classes
     */
    public function setSchool(\VOCS\PlatformBundle\Entity\Schools $school = null)
    {

        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \VOCS\PlatformBundle\Entity\Schools
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lists = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function injectObjectManager(ObjectManager $objectManager, ClassMetadata $classMetadata ) {
        $this->em = $objectManager;
    }

    /**
     * Add user
     *
     * @param \VOCS\PlatformBundle\Entity\User $user
     *
     * @return Classes
     */
    public function addUser(\VOCS\PlatformBundle\Entity\User $user)
    {

        $user->addClass($this);
        $this->users->add($user);

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
     * Add list
     *
     * @param \VOCS\PlatformBundle\Entity\Lists $list
     *
     * @return Classes
     */
    public function addList(\VOCS\PlatformBundle\Entity\Lists $list)
    {

        foreach ($list->getWordTrads() as $wordTrad) {
            foreach ($this->users as $user) {
                $wtu = new WordTradUser();
                $wtu->setGoodRepetition(0);
                $wtu->setBadRepetition(0);
                $wtu->setLevel(0);
                $wtu->setUser($this);
                $wtu->setWordTrad($wordTrad);

                $this->em->persist($wtu);
            }

        }
        $this->em->flush();
        return $this;
    }

    /**
     * Remove list
     *
     * @param \VOCS\PlatformBundle\Entity\Lists $list
     */
    public function removeList(\VOCS\PlatformBundle\Entity\Lists $list)
    {
        $this->lists->removeElement($list);
    }

    /**
     * Get lists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLists()
    {
        return $this->lists;
    }
}
