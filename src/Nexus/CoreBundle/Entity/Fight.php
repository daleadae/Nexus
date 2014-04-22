<?php

namespace Nexus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fight
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nexus\CoreBundle\Entity\FightRepository")
 */
class Fight
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="result", type="boolean")
     */
    private $result;

    /**
     * @var float
     *
     * @ORM\Column(name="damage_done", type="float")
     */
    private $damageDone;

    /**
     * @var float
     *
     * @ORM\Column(name="damage_taken", type="float")
     */
    private $damageTaken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set result
     *
     * @param boolean $result
     * @return Fight
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return boolean 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set damageDone
     *
     * @param float $damageDone
     * @return Fight
     */
    public function setDamageDone($damageDone)
    {
        $this->damageDone = $damageDone;

        return $this;
    }

    /**
     * Get damageDone
     *
     * @return float 
     */
    public function getDamageDone()
    {
        return $this->damageDone;
    }

    /**
     * Set damageTaken
     *
     * @param float $damageTaken
     * @return Fight
     */
    public function setDamageTaken($damageTaken)
    {
        $this->damageTaken = $damageTaken;

        return $this;
    }

    /**
     * Get damageTaken
     *
     * @return float 
     */
    public function getDamageTaken()
    {
        return $this->damageTaken;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Fight
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
