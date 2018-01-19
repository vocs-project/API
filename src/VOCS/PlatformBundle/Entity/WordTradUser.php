<?php

namespace VOCS\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WordTradUser
 *
 * @ORM\Table(name="word_trad_user")
 * @ORM\Entity(repositoryClass="VOCS\PlatformBundle\Repository\WordTradUserRepository")
 */
class WordTradUser
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="WordTrad")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wordTrad;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="good_repetition", type="integer")
     */
    private $goodRepetition;


    /**
     * @var int
     *
     * @ORM\Column(name="bad_repetition", type="integer")
     */
    private $badRepetition;

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
     * Set user
     *
     * @param \VOCS\PlatformBundle\Entity\User $user
     *
     * @return WordTradUser
     */
    public function setUser(\VOCS\PlatformBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \VOCS\PlatformBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set wordTrad
     *
     * @param \VOCS\PlatformBundle\Entity\WordTrad $wordTrad
     *
     * @return WordTradUser
     */
    public function setWordTrad(\VOCS\PlatformBundle\Entity\WordTrad $wordTrad)
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

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return WordTradUser
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set goodRepetition
     *
     * @param integer $goodRepetition
     *
     * @return WordTradUser
     */
    public function setGoodRepetition($goodRepetition)
    {
        $this->goodRepetition = $goodRepetition;

        return $this;
    }

    /**
     * Get goodRepetition
     *
     * @return integer
     */
    public function getGoodRepetition()
    {
        return $this->goodRepetition;
    }

    /**
     * Set badRepetition
     *
     * @param integer $badRepetition
     *
     * @return WordTradUser
     */
    public function setBadRepetition($badRepetition)
    {
        $this->badRepetition = $badRepetition;

        return $this;
    }

    /**
     * Get badRepetition
     *
     * @return integer
     */
    public function getBadRepetition()
    {
        return $this->badRepetition;
    }
}
