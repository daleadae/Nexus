<?php

namespace Nexus\CoreBundle\Entity;

use Nexus\CoreBundle\Models\UnitModel as BaseUnit;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Monster
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nexus\CoreBundle\Entity\MonsterRepository")
 * @ExclusionPolicy("none")
 */
class Monster extends BaseUnit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Exclude
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar;

    /**
     * @var integer
     *
     */
    private $level;

    /**
     * @var float
     *
     */
    private $health;

    /**
     * @var integer
     *
     */
    private $type;

    /**
     * @var float
     *
     */
    private $experience;

    /**
     * @var float
     *
     */
    private $experienceReward;

    /**
     * @var float
     *
     */
    private $attackSpeed;

    /**
     * @var float
     *
     */
    private $power;

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
     * @return Monster
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
     * Set avatar
     *
     * @param string $avatar
     * @return Monster
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set health
     *
     * @param float $health
     * @return Monster
     */
    public function setHealth($health)
    {
        $this->health = round($health, 2);

        return $this;
    }

    /**
     * Get health
     *
     * @return float 
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set attackSpeed
     *
     * @param float $attackSpeed
     * @return Monster
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
     * Set power
     *
     * @param float $power
     * @return Monster
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return float 
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Monster
     */
    public function setExperience($experience)
    {
        $this->experience = round($experience);

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->getExperienceForLevel($this->getLevel());
    }        

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Monster
     */
    public function setExperienceReward($experience)
    {
        $this->experienceReward = round($experience);

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperienceReward()
    {
        return $this->experienceReward;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Monster
     */
    public function setLevel($level)
    {
        $this->level = $level;

        $power = 1+($level-1)/10; // Calc power for the level
        $this->setPower($power);

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
     * Set type
     *
     * @param integer $type
     * @return Monster
     */
    public function setType($type)
    {
        $this->type = $type;

        if ($this->type == 1) {                 // Mob type == normal
            $this->setAttackSpeed(1);           // Attack Speed = 1 AS
            $this->setHealth(50);               // Health = 50 HP
            $experience = ($this->getExperienceForLevel($this->level+1)-$this->getExperienceForLevel($this->level))*0.2;
            $this->setExperienceReward($experience);  // Experience = 20% experience of the current level
        } else {                                // Mob type = elite
            $this->setAttackSpeed(1.2);         // Attack Speed = 1.2 AS
            $this->setHealth(75);               // Hleath = 75 HP
            $experience = ($this->getExperienceForLevel($this->level+1)-$this->getExperienceForLevel($this->level))*0.4;
            $this->setExperienceReward($experience);  // Experience = 40% experience of the current leve
        }

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

    public function __toString()
    {
        return ($this->getName()) ? : '-';
    }    
}
