<?php

namespace Nexus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FightLog
 *
 * @ORM\Table(name="fight_log")
 * @ORM\Entity(repositoryClass="Nexus\CoreBundle\Entity\FightLogRepository")
 */
class FightLog
{
    /**
     * @ORM\ManyToOne(targetEntity="Nexus\CoreBundle\Entity\Characters", inversedBy="fightLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $character;

    /**
     * @ORM\ManyToOne(targetEntity="Nexus\CoreBundle\Entity\Monster")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monster;    

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
     * @var integer
     *
     * @ORM\Column(name="monster_type", type="integer")
     */
    private $monsterType;

    /**
     * @var integer
     *
     * @ORM\Column(name="monster_experience_reward", type="integer")
     */
    private $monsterExperienceReward;

    /**
     * @var integer
     * @ORM\Column(name="monster_level", type="integer")     
     *
     */
    private $monsterLevel;

    /**
     * @var integer
     * @ORM\Column(name="character_level", type="integer")     
     *
     */
    private $characterLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="character_level_final", type="integer")
     */
    private $characterLevelFinal;

    /**
     * @var integer
     *
     */
    private $characterStartHealth;

    /**
     * @var integer
     *
     */
    private $monsterStartHealth; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
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
     * Set result
     *
     * @param boolean $result
     * @return FightLog
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
     * @return FightLog
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
     * @return FightLog
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
     * @return FightLog
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

    /**
     * Set monsterType
     *
     * @param integer $monsterType
     * @return FightLog
     */
    public function setMonsterType($monsterType)
    {
        $this->monsterType = $monsterType;

        return $this;
    }

    /**
     * Get monsterType
     *
     * @return integer 
     */
    public function getMonsterType()
    {
        return $this->monsterType;
    }

    /**
     * Set monsterExperienceReward
     *
     * @param integer $monsterExperienceReward
     * @return FightLog
     */
    public function setMonsterExperienceReward($monsterExperienceReward)
    {
        $this->monsterExperienceReward = $monsterExperienceReward;

        return $this;
    }

    /**
     * Get monsterExperienceReward
     *
     * @return integer 
     */
    public function getMonsterExperienceReward()
    {
        return $this->monsterExperienceReward;
    }

    /**
     * Set monsterLevel
     *
     * @param integer $monsterLevel
     * @return FightLog
     */
    public function setMonsterLevel($monsterLevel)
    {
        $this->monsterLevel = $monsterLevel;

        return $this;
    }

    /**
     * Get monsterLevel
     *
     * @return integer 
     */
    public function getMonsterLevel()
    {
        return $this->monsterLevel;
    }

    /**
     * Set characterLevel
     *
     * @param integer $characterLevel
     * @return FightLog
     */
    public function setCharacterLevel($characterLevel)
    {
        $this->characterLevel = $characterLevel;

        return $this;
    }

    /**
     * Get characterLevel
     *
     * @return integer 
     */
    public function getCharacterLevel()
    {
        return $this->characterLevel;
    }

    /**
     * Set characterLevelFinal
     *
     * @param integer $characterLevelFinal
     * @return FightLog
     */
    public function setCharacterLevelFinal($characterLevelFinal)
    {
        $this->characterLevelFinal = $characterLevelFinal;

        return $this;
    }

    /**
     * Get characterLevelFinal
     *
     * @return integer 
     */
    public function getCharacterLevelFinal()
    {
        return $this->characterLevelFinal;
    }

    /**
     * Set character
     *
     * @param \Nexus\CoreBundle\Entity\Characters $character
     * @return FightLog
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

    /**
     * Set monster
     *
     * @param \Nexus\CoreBundle\Entity\Monster $monster
     * @return FightLog
     */
    public function setMonster(\Nexus\CoreBundle\Entity\Monster $monster)
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * Get monster
     *
     * @return \Nexus\CoreBundle\Entity\Monster 
     */
    public function getMonster()
    {
        return $this->monster;
    }

    /**
     * Set characterStartHealth
     *
     * @param integer $characterStartHealth
     * @return FightLog
     */
    public function setCharacterStartHealth($characterStartHealth)
    {
        $this->characterStartHealth = $characterStartHealth;

        return $this;
    }

    /**
     * Get characterStartHealth
     *
     * @return integer 
     */
    public function getCharacterStartHealth()
    {
        return $this->characterStartHealth;
    }

    /**
     * Set monsterStartHealth
     *
     * @param integer $monsterStartHealth
     * @return FightLog
     */
    public function setMonsterStartHealth($monsterStartHealth)
    {
        $this->monsterStartHealth = $monsterStartHealth;

        return $this;
    }

    /**
     * Get monsterStartHealth
     *
     * @return integer 
     */
    public function getMonsterStartHealth()
    {
        return $this->monsterStartHealth;
    }

    /**
     * Get Time Ago
     * @return string
     */
    public function get_time_difference_php($created_time)
    {
        //date_default_timezone_set('Europe/Dublin'); //Change as per your default time
        $str = strtotime($created_time);
        $today = strtotime(date('Y-m-d H:i:s'));

        // It returns the time difference in Seconds...
        $time_differnce = $today-$str;

        // To Calculate the time difference in Years...
        $years = 60*60*24*365;

        // To Calculate the time difference in Months...
        $months = 60*60*24*30;

        // To Calculate the time difference in Days...
        $days = 60*60*24;

        // To Calculate the time difference in Hours...
        $hours = 60*60;

        // To Calculate the time difference in Minutes...
        $minutes = 60;

        if(intval($time_differnce/$years) > 1)
        {
            return intval($time_differnce/$years)." years ago";
        }else if(intval($time_differnce/$years) > 0)
        {
            return intval($time_differnce/$years)." year ago";
        }else if(intval($time_differnce/$months) > 1)
        {
            return intval($time_differnce/$months)." months ago";
        }else if(intval(($time_differnce/$months)) > 0)
        {
            return intval(($time_differnce/$months))." month ago";
        }else if(intval(($time_differnce/$days)) > 1)
        {
            return intval(($time_differnce/$days))." days ago";
        }else if (intval(($time_differnce/$days)) > 0) 
        {
            return intval(($time_differnce/$days))." day ago";
        }else if (intval(($time_differnce/$hours)) > 1) 
        {
            return intval(($time_differnce/$hours))." hours ago";
        }else if (intval(($time_differnce/$hours)) > 0) 
        {
            return intval(($time_differnce/$hours))." hour ago";
        }else if (intval(($time_differnce/$minutes)) > 1) 
        {
            return intval(($time_differnce/$minutes))." minutes ago";
        }else if (intval(($time_differnce/$minutes)) > 0) 
        {
            return intval(($time_differnce/$minutes))." minute ago";
        }else if (intval(($time_differnce)) > 1) 
        {
            return intval(($time_differnce))." seconds ago";
        }else
        {
            return "few seconds ago";
        }
    }
}
