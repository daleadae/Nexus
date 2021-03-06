<?php

namespace Nexus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WeeklyUpdate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nexus\CoreBundle\Entity\WeeklyUpdateRepository")
 */
class WeeklyUpdate
{
    /**
    * @ORM\ManyToOne(targetEntity="Nexus\CoreBundle\Entity\Characters", inversedBy="updates")
    * @ORM\JoinColumn(nullable=false)
    */
    private $character;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="experience_1", type="float")
     * @Assert\NotBlank()
     */
    private $experience1;

    /**
     * @var float
     *
     * @ORM\Column(name="experience_2", type="float")
     * @Assert\NotBlank()
     */
    private $experience2;

    /**
     * @var float
     *
     * @ORM\Column(name="damage_1", type="float")
     * @Assert\NotBlank()
     */
    private $damage1;

    /**
     * @var float
     *
     * @ORM\Column(name="damage_2", type="float")
     * @Assert\NotBlank()
     */
    private $damage2;

    /**
     * @var float
     *
     * @ORM\Column(name="armor", type="float")
     * @Assert\NotBlank()
     */
    private $armor;

    /**
     * @var float
     *
     * @ORM\Column(name="resist", type="float")
     * @Assert\NotBlank()
     */
    private $resist;

    /**
     * @var float
     *
     * @ORM\Column(name="mitigation", type="float")
     * @Assert\NotBlank()
     */
    private $mitigation; 

    /**
     * @var float
     *
     * @ORM\Column(name="attack_speed", type="float")
     * @Assert\NotBlank()
     */
    private $attackSpeed;

    /**
     * @var float
     *
     * @ORM\Column(name="health_lost", type="float")
     * @Assert\NotBlank()
     */
    private $healthLost;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\DateTime()
     */
    private $date;        

    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set experience1
     *
     * @param float $experience1
     * @return WeeklyUpdate
     */
    public function setExperience1($experience1)
    {
        $this->experience1 = $experience1;

        return $this;
    }

    /**
     * Get experience1
     *
     * @return float 
     */
    public function getExperience1()
    {
        return $this->experience1;
    }

    /**
     * Set experience2
     *
     * @param float $experience2
     * @return WeeklyUpdate
     */
    public function setExperience2($experience2)
    {
        $this->experience2 = $experience2;

        return $this;
    }

    /**
     * Get experience2
     *
     * @return float 
     */
    public function getExperience2()
    {
        return $this->experience2;
    }

    /**
     * Set damage1
     *
     * @param float $damage1
     * @return WeeklyUpdate
     */
    public function setDamage1($damage1)
    {
        $this->damage1 = $damage1;

        return $this;
    }

    /**
     * Get damage1
     *
     * @return float 
     */
    public function getDamage1()
    {
        return $this->damage1;
    }

    /**
     * Set damage2
     *
     * @param float $damage2
     * @return WeeklyUpdate
     */
    public function setDamage2($damage2)
    {
        $this->damage2 = $damage2;

        return $this;
    }

    /**
     * Get damage2
     *
     * @return float 
     */
    public function getDamage2()
    {
        return $this->damage2;
    }

    /**
     * Set armor
     *
     * @param float $armor
     * @return WeeklyUpdate
     */
    public function setArmor($armor)
    {
        $this->armor = $armor;

        return $this;
    }

    /**
     * Get armor
     *
     * @return float 
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * Set resist
     *
     * @param float $resist
     * @return WeeklyUpdate
     */
    public function setResist($resist)
    {
        $this->resist = $resist;

        return $this;
    }

    /**
     * Get resist
     *
     * @return float 
     */
    public function getResist()
    {
        return $this->resist;
    }

    /**
     * Set mitigation
     *
     * @param float $mitigation
     * @return WeeklyUpdate
     */
    public function setMitigation($mitigation)
    {
        $this->mitigation = $mitigation;

        return $this;
    }

    /**
     * Get mitigation
     *
     * @return float 
     */
    public function getMitigation()
    {
        return $this->mitigation;
    }

    /**
     * Set attackSpeed
     *
     * @param float $attackSpeed
     * @return WeeklyUpdate
     */
    public function setAttackSpeed($attackSpeed)
    {
        $this->attackSpeed = $attackSpeed;

        return $this;
    }

    /**
     * Get attackSpeed
     *
     * @return float 
     */
    public function getAttackSpeed()
    {
        return $this->attackSpeed;
    }

    /**
     * Set healthLost
     *
     * @param float $healthLost
     * @return WeeklyUpdate
     */
    public function setHealthLost($healthLost)
    {
        $this->healthLost = $healthLost;

        return $this;
    }

    /**
     * Get healthLost
     *
     * @return float 
     */
    public function getHealthLost()
    {
        return $this->healthLost;
    }

    /**
     * Set character
     *
     * @param \Nexus\CoreBundle\Entity\Characters $character
     * @return WeeklyUpdate
     */
    public function setCharacter(\Nexus\CoreBundle\Entity\Characters $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return \Nexus\CoreBundle\Entity\Characters 
     */
    public function getCharacter()
    {
        return $this->character;
    }

    public function __toString()
    {
        if ($this->getCharacter()) {
            return ($this->getCharacter()->getName()) ? : '-';  
        } else {
            return '-';
        }
    }    

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return WeeklyUpdate
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
