<?php

namespace VOCS\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WordTrad
 *
 * @ORM\Table(name="word_trad")
 * @ORM\Entity(repositoryClass="VOCS\PlatformBundle\Repository\WordTradRepository")
 */
class WordTrad

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
     * @ORM\ManyToOne(targetEntity="Words", cascade={"persist"})
     * @ORM\JoinColumns(
     *     {
     *          @ORM\JoinColumn(name="word_id", referencedColumnName="id"),
     *
     *     })
     */
    private $word;

    /**
     * @ORM\ManyToOne(targetEntity="Words", cascade={"persist"})
     * @ORM\JoinColumns(
     *     {
     *          @ORM\JoinColumn(name="trad_id", referencedColumnName="id"),
     *
     *     })
     */
    private $trad;


    /**
     * @var WordTradUser
     */
    private $stat;


    public function getStat() {
        return $this->stat;
    }

    public function setStat(WordTradUser $wtu) {
        $this->stat = $wtu;
    }

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
     * Set word
     *
     * @param \VOCS\PlatformBundle\Entity\Words $word
     *
     * @return WordTrad
     */

    public function setWord(\VOCS\PlatformBundle\Entity\Words $word)

    {

        $this->word = $word;

        return $this;

    }

    /**
     * Get word
     *
     * @return \VOCS\PlatformBundle\Entity\Words
     */

    public function getWord()

    {

        return $this->word;

    }

    /**
     * Set trad
     *
     * @param \VOCS\PlatformBundle\Entity\Words $trad
     *
     * @return WordTrad
     */

    public function setTrad(\VOCS\PlatformBundle\Entity\Words $trad)

    {

        $this->trad = $trad;

        return $this;

    }

    /**
     * Get trad
     *
     * @return \VOCS\PlatformBundle\Entity\Words
     */

    public function getTrad()

    {

        return $this->trad;

    }

}
