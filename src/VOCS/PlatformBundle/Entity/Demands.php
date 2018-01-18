<?php

namespace VOCS\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demands
 *
 * @ORM\Table(name="demands")
 * @ORM\Entity(repositoryClass="VOCS\PlatformBundle\Repository\DemandsRepository")
 */
class Demands
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
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userSend_id", referencedColumnName="id")
     */
    private $userSend;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userReceive_id", referencedColumnName="id")
     */
    private $userReceive;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Classes")
     * @ORM\JoinColumn(name="classe_id", referencedColumnName="id")
     */
    private $classe;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Lists")
     * @ORM\JoinColumn(name="lists_id", referencedColumnName="id")
     */
    private $list;

    /**
     *
     * @ORM\ManyToOne(targetEntity="WordTrad", cascade={"persist"})
     * @ORM\JoinColumn(name="wordTrad_id", referencedColumnName="id")
     */
    private $wordTrad;

    /**
     * Set userSend
     *
     * @param \VOCS\PlatformBundle\Entity\User $userSend
     *
     * @return Demands
     */
    public function setUserSend(\VOCS\PlatformBundle\Entity\User $userSend = null)
    {
        $this->userSend = $userSend;

        return $this;
    }

    /**
     * Get userSend
     *
     * @return \VOCS\PlatformBundle\Entity\User
     */
    public function getUserSend()
    {
        return $this->userSend;
    }

    /**
     * Set userReceive
     *
     * @param \VOCS\PlatformBundle\Entity\User $userReceive
     *
     * @return Demands
     */
    public function setUserReceive(\VOCS\PlatformBundle\Entity\User $userReceive = null)
    {
        $this->userReceive = $userReceive;

        return $this;
    }

    /**
     * Get userReceive
     *
     * @return \VOCS\PlatformBundle\Entity\User
     */
    public function getUserReceive()
    {
        return $this->userReceive;
    }

    /**
     * Set classe
     *
     * @param \VOCS\PlatformBundle\Entity\Classes $classe
     *
     * @return Demands
     */
    public function setClasse(\VOCS\PlatformBundle\Entity\Classes $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \VOCS\PlatformBundle\Entity\Classes
     */
    public function getClasse()
    {
        return $this->classe;
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
     * Set list
     *
     * @param \VOCS\PlatformBundle\Entity\Lists $list
     *
     * @return Demands
     */
    public function setList(\VOCS\PlatformBundle\Entity\Lists $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \VOCS\PlatformBundle\Entity\Lists
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set wordTrad
     *
     * @param \VOCS\PlatformBundle\Entity\WordTrad $wordTrad
     *
     * @return Demands
     */
    public function setWordTrad(\VOCS\PlatformBundle\Entity\WordTrad $wordTrad = null)
    {
        $this->wordTrad = $wordTrad;

        return $this;
    }

    /**
     * Get wordTrad
     *
     * @return \VOCS\PlatformBundle\Entity\WordTrad
     */
    public function getWordTrad()
    {
        return $this->wordTrad;
    }
}
